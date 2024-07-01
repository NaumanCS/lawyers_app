<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\DeviceToken;
use App\Models\LawyersTimeSpan;
use App\Models\Service;
use App\Models\User;
use App\Models\VerifyToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $data = $request->only('email', 'password','user_type');
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required|string|min:6|max:50',
            'user_type' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        $reason = User::where('email', $request->email)->first('reason');

        if (!$user) {
            // return response(['code' => 404, 'message' => 'Phone Number does not exist']);
            return response()->json(['error' => 'email does not exist'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response(['status' => false, 'error' => 'Invalid email or password. Please try again'], 404);
        }
        if($user->role == 'user' && $request->user_type == 'lawyer'){
            return response(['status' => false, 'error' => 'You cant access as a '.$request->user_type], 500);
        }
       
        $updateUserType=$user->update([
            'user_type' => $request->user_type
        ]);
        if ($user->role == 'lawyer') {
            if ($user->document_status == 'approved') {
                $device_token = DeviceToken::where('user_id',$user->id)->first();
               
                if ($device_token) {
                    $device_token->update([
                        'user_id' => $user->id,
                        'device_token' => $request->device_token,
                    ]);
                }else{
                    DeviceToken::create([
                        'user_id' => $user->id,
                        'device_token' => $request->device_token,
                    ]); 
                }

                return ['code' => 200, 'status' => true, 'message' => 'Login Successfully', 'reason' => $reason,'user_type'=>$request->user_type, 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
            } elseif ($user->document_status == 'depreciated') {

                return ['code' => 200, 'status' => true, 'message' => 'It is informed to you that some of your documents are not approved.', 'reason' => $reason, 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
            } else {
                return ['code' => 200, 'status' => true, 'message' => 'Your document is not approved yet,We will shortly verify your profile, and you can provide services.', 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
            }
        } else {
            return ['code' => 200, 'status' => true, 'message' => 'Login Successfully','user_type'=>$request->user_type, 'data' => $user, 'access_token' => $user->createToken($request->email)->plainTextToken];
        }
    }

    public function register_customer(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:users|digits:11', // Ensure unique phone number
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

            return response()->json(['user' => $user, 'access_token' => $token], 200);
        } else {
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }

    public function register_lawyer(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone|max:11|min:11',
            'email' => 'required',
            'city' => 'required',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $user =  User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'city' => $request['city'],
            // 'degree' => $request['degree'],
            'advocate' => $request['advocate'],
            'high_court' => $request['high_court'],
            'supreme_court' => $request['supreme_court'],
            'experience_in_years' => $request['experience_in_years'],
            'qualification' => $request['qualification'],
            'password' => Hash::make($request['password']),
            'role' => 'lawyer',
            'document_status' => 'pending',
        ]);

        if ($request->file('image')) {
            $userProfile = rand(0, 9999) . time() . '.' . $request->image->extension();
            $request->file('image')->move(public_path('uploads/user'), $userProfile);

            User::whereId($user->id)->update([
                'image' => $userProfile
            ]);
        }

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
        //  $categoriesString = $request->categories;
        // $categoriesObject = json_decode($categoriesString);
        // $categoriesArray = $categoriesObject->categories;
        // $categoryResponse = ["categories" => $categoriesArray];
        // $categoryIds = array_map('intval', $categoriesArray);; // Convert array values to integers

        // $jsonString = $request->days;
        // $jsonObject = json_decode($jsonString);
        // $daysArray = $jsonObject->days;

        $category1 = $request->category1 ?? null;
        $category2 = $request->category2 ?? null;

        $categories = [$category1, $category2];


        // Convert array values to integers using array_map
        $categoryIds = array_map('intval', $categories);

        $selectedDays = $request->input('days', []);
        //    dd($selectedDays);

        foreach ($categoryIds as $categoryId) {
            $service = new Service();
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $categoryId; // Store the integer value
            $service->days = $selectedDays;
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->user_id = $user->id;



            $service->save();
        }

        $accountDetail = AccountDetail::create($request->except('_access_token', 'user_id', 'user_type'));
        $accountDetail->user_id = $user->id;
        $accountDetail->user_type = 'lawyer';
        $accountDetail->save();

        $this->make_time_slots($user->id, $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

        if ($user) {
            // Assuming you want to generate an API token for the user after registration
            $token = $user->createToken('apiToken')->plainTextToken;

            return response()->json(['message' => 'Account created Successfully', 'data' => $user, 'service' => $service, 'accountDetail' => $accountDetail, 'access_token' => $token], 200);
        } else {
            return response()->json(['error' => 'Failed to create Lawyer Account'], 500);
        }
    }

    public function make_time_slots($user_id, $service_id, $req_start_time, $req_end_time, $req_extra_day_start_time, $req_extra_day_end_time)
    {

        $time_spans = LawyersTimeSpan::where('user_id', $user_id)->where('service_id', $service_id)->delete();
        $start_time = Carbon::createFromFormat('H:i', $req_start_time);
        $end_time = Carbon::createFromFormat('H:i', $req_end_time);
        $slot_duration = 30;
        $timeSlots = [];
        $extraDayTimeSlots = [];


        while ($start_time <= $end_time) {
            $slot_start = $start_time->format('H:i');
            $start_time->addMinutes($slot_duration);
            $slot_end = $start_time->format('H:i');

            $timeSlots[] = $slot_start . ' - ' . $slot_end;
        }

        while ($start_time >= $end_time) {
            $slot_start = $end_time->format('H:i');
            $end_time->addMinutes($slot_duration);
            $slot_end = $end_time->format('H:i');

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


    public function send_otp(Request $request)
    {

        $request->validate([

            'email' => 'required|exists:users'

        ]);
        session()->put('phone', $request->phone);



        VerifyToken::where('email', $request->email)->delete();
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = rand(111111, 999999);
            VerifyToken::insert([
                'email' => $user->email,
                'otp' => $otp
            ]);

            $from = getenv("MAIL_FROM_ADDRESS");


            Mail::send('front-layouts.pages.emails.otp-email', ['user' => $user, 'token' => $otp, 'from' => $from], function ($m) use ($user, $otp, $from) {
                $m->from($from, 'Al-Wakeel');

                $m->to($user->email, $user->name)->subject('Forgot Password Otp');
            });
            return response()->json(['message' => 'Otp Sent to your phone number'], 200);
        } else {

            return response()->json(['error' => 'Failed to send otp'], 500);
        }
    }

    public function resend_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|phone|exists:users'
        ]);
        session()->put('phone', $request->phone);

        VerifyToken::where('phone', $request->phone)->delete();
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $otp = rand(111111, 999999);
            VerifyToken::insert([
                'phone' => $user->phone,
                'token' => $otp
            ]);
            $userPhone = '+92' . ltrim($user->phone, '0');
            $message = "Your OTP is" . $otp;


            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($userPhone, [
                'from' => $twilio_number,
                'body' => $message
            ]);
            // Mail::send('emails.verification', ['user' => $user, 'otp' => $otp], function ($m) use ($user, $token) {
            //     $m->from('info@dwive758.com', 'medullaEffect');

            //     $m->to($user->otp, $user->name)->subject('Forgot Password otp');
            // });

            return back();
        } else {

            return back();
        }
    }

    function verify_otp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "otp" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['phone' => "The phone number you provided doesn't belong to any account"]);
        } else {
            $requestToken = $request->otp;
            $otp = VerifyToken::where('otp', $requestToken)->first();

            if (isset($otp)) { // Check if $otp is not null
                $userEmail = User::where('email', $otp->email)->first();
                $userEmail->update([
                    'otp_verified' => 1,
                ]);
                if ($userEmail) {
                    VerifyToken::where('otp', $request->otp)->delete();

                    return response()->json(['message' => 'Otp Verified'], 200);
                } else {
                    return response()->json(['error' => 'Invalid Otp'], 500);
                }
            } else {
                return response()->json(['error' => 'Invalid Otp'], 500);
            }
        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            "password" => "required"
        ]);
        $userEmail = User::where('email', $request->email)->first();

        if ($userEmail->otp_verified == 1) {
            $result = User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);
            if (isset($result) && !empty($result)) {
                $userEmail->update([
                    'otp_verified' => null,
                ]);
                return response()->json(['message' => 'Password Reset Successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to reset password'], 500);
            }
        } else {
            return response()->json(['error' => 'Otp not verified'], 500);
        }
    }
}
