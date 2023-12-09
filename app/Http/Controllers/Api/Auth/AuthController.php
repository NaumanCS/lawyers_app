<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\LawyersTimeSpan;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $data = $request->only('phone', 'password');
        $validator = Validator::make($data, [
            'phone' => 'required',
            'password' => 'required|string|min:6|max:50'
        ]);
    
        $user = User::where('phone', $request->phone)->first();
        if (!$user){
            return response(['status' => false, 'message' => 'Phone Number does not exist'], 200);
        }
    
        if (!Hash::check($request->password, $user->password)){
            return response(['status' => false, 'message' => 'Invalid phone or password. Please try again'], 200);
        }
    
        return ['code' => 200, 'status' => true, 'message' => 'Login Successfully', 'data' => $user, 'access_token' => $user->createToken($request->phone)->plainTextToken];
    }

    public function register_customer(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:users|digits:10', // Ensure unique phone number
            'city' => 'required|string',
            'password' => 'required|min:6',
        ]);

        // Check if phone or email already exists
        if (User::where('phone', $validatedData['phone'])->exists()) {
            return response()->json(['error' => 'Phone already exists'], 400);
        }

        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'email' => $request['email'],
            'city' => $validatedData['city'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'user',
        ]);

        if ($user) {
            // Assuming you want to generate an API token for the user after registration
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);
        } else {
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }

    public function register_lawyer(Request $request)
    {
      
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'city' => 'required',
            'country' => 'required',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $user =  User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'city' => $request['city'],
            'country' => $request['country'],
            'degree' => $request['degree'],
            'advocate' => $request['advocate'],
            'high_court' => $request['high_court'],
            'supreme_court' => $request['supreme_court'],
            'experience_in_years' => $request['experience_in_years'],
            'qualification' => $request['qualification'],
            'password' => Hash::make($request['password']),
            'role' => 'lawyer',
            'document_status' => 'pending',
        ]);

        if ($request->file('advocate_licence')) {
            $advocateLicence = time() . '.' . $request->advocate_licence->extension();
            $request->advocate_licence->move(public_path('uploads/lawyer/documents'), $advocateLicence);
            User::whereId($user->id)->update([
                'advocate_licence' => $advocateLicence
            ]);
        }
        if ($request->file('high_court_licence')) {
            $highCourtLicence = time() . '.' . $request->high_court_licence->extension();
            $request->high_court_licence->move(public_path('uploads/lawyer/documents'), $highCourtLicence);
            User::whereId($user->id)->update([
                'high_court_licence' => $highCourtLicence
            ]);
        }
        if ($request->file('supreme_court_licence')) {
            $supremeCourtLicence = time() . '.' . $request->supreme_court_licence->extension();
            $request->supreme_court_licence->move(public_path('uploads/lawyer/documents'), $supremeCourtLicence);
            User::whereId($user->id)->update([
                'supreme_court_licence' => $supremeCourtLicence
            ]);
        }
        if ($request->file('qualification_certificate')) {
            $qualificationCertificate = time() . '.' . $request->qualification_certificate->extension();
            $request->qualification_certificate->move(public_path('uploads/lawyer/documents'), $qualificationCertificate);
            User::whereId($user->id)->update([
                'qualification_certificate' => $qualificationCertificate
            ]);
        }
        

        // add service data
        $categoryIds = array_map('intval', $request->categories); // Convert array values to integers
        $selectedDays = $request->input('days', []);
        foreach ($categoryIds as $categoryId) {
            $service = new Service();
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $categoryId; // Store the integer value
            $service->days = json_encode($selectedDays);
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->user_id =$user->id;
            
            if ($request->file('image')) {
                $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                $request->file('image')->move(public_path('uploads/lawyer/service'), $imageName);
                $service->cover_image = $imageName;
            }
            
            $service->save();
        }
        
        $accountDetail = AccountDetail::create($request->except( '_token','user_id','user_type'));
        $accountDetail->user_id=$user->id;
        $accountDetail->user_type='lawyer';
        $accountDetail->save();
     
        $this->make_time_slots($user->id, $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

        if ($user) {
            // Assuming you want to generate an API token for the user after registration
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(['user' => $user,'service' => $service,'accountDetail' => $accountDetail, 'token' => $token], 201);
        } else {
            return response()->json(['error' => 'Failed to create Lawyer Account'], 500);
        }

        
    }

    public function make_time_slots($user_id, $service_id, $req_start_time, $req_end_time, $req_extra_day_start_time, $req_extra_day_end_time)
    {
        // dd('1');
        $time_spans = LawyersTimeSpan::where('user_id', $user_id)->where('service_id', $service_id)->delete();
        $start_time = Carbon::createFromFormat('H:i', $req_start_time);
        $end_time = Carbon::createFromFormat('H:i', $req_end_time);
        $slot_duration = 20;
        $timeSlots = [];
        $extraDayTimeSlots = [];

        while ($start_time <= $end_time) {
            $slot_start = $start_time->format('H:i');
            $start_time->addMinutes($slot_duration);
            $slot_end = $start_time->format('H:i');

            $timeSlots[] = $slot_start . ' - ' . $slot_end;
        }
        if ($req_extra_day_start_time && $req_extra_day_end_time) {
            $extra_day_start_time = Carbon::createFromFormat('H:i', $req_extra_day_start_time);
            $extra_day_end_time = Carbon::createFromFormat('H:i', $req_extra_day_end_time);

            while ($extra_day_start_time <= $extra_day_end_time) {
                $extra_slot_start = $extra_day_start_time->format('H:i');
                $extra_day_start_time->addMinutes($slot_duration);
                $extra_slot_end = $extra_day_start_time->format('H:i');

                $timeSlots[] = $extra_slot_start . ' - ' . $extra_slot_end;
            }
        }
        // dd($timeSlots);

        $slotsData = [];
        foreach ($timeSlots as $key => $timeSlot) {
            $slotsData[] = [
                'user_id' => $user_id,
                'service_id' => $service_id,
                'time_spans' => $timeSlot,
                'extra_day_time_spans' => $extraDayTimeSlots[$key] ?? null,
            ];
        }
        DB::table('lawyers_time_spans')->insert($slotsData);

        return $slotsData;
    }

}
