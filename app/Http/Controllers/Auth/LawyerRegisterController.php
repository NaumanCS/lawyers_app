<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\Category;
use App\Models\LawyersTimeSpan;
use App\Models\Service;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LawyerRegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => 'required|min:11',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function index()
    {
        $categories = Category::get();
        return view('front-layouts.pages.auth.lawyer_register', get_defined_vars());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(Request $request)
    {
      
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'password' => 'required|string|min:8|confirmed',

        ]);

        $user =  User::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'address' => $request['address'],
            'city' => $request['city'],
            'country' => $request['country'],
            'degree' => $request['degree'],
            'high_court' => $request['high_court'],
            'supreme_court' => $request['supreme_court'],
            'experience_in_years' => $request['experience_in_years'],
            'qualification' => $request['qualification'],
            'password' => Hash::make($request['password']),
            'role' => 'lawyer',
            'document_status' => 'pending',
        ]);

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
            Auth::login($user);
            return redirect()->route('lawyer.dashboard');
        } else {
            return redirect()->back()->with('error', 'You do not have access to this page');
        }
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string',
        //     'location' => 'required|string',
        //     'amount' => 'required|numeric',
        //     'categories_id' => 'required',
        //     'start_day' => 'required',
        //     'end_day' => 'required',
        //     'start_time' => 'required',
        //     'end_time' => 'required',
        //     'add_extra_day' => 'required',
        //     'cover_image' => 'required',
        // ]);

        $update_id = $request->id;
        if ($update_id) {
            $service = Service::where('id', $request->id)->first();
            $service->title = $request->title;
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $request->categories_id;
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->add_extra_day = $request->add_extra_day;
            $service->extra_day = $request->extra_day;
            $service->extra_day_start_time = $request->extra_day_start_time;
            $service->extra_day_end_time = $request->extra_day_end_time;
            $service->user_id = Auth::id();

            if ($request->file()) {
                $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                $request->file('cover_image')->move(public_path('uploads/lawyer/service'), $imageName);
                $service->image = $imageName;
            }
            $service->update();

            $this->make_time_slots(Auth::id(), $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

            return redirect()->route('lawyer.service.list')->with('message', 'Service Updated Successfully');
        } else {
            $service = new Service();

            $service->title = $request->title;
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $request->categories_id;
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->add_extra_day = $request->add_extra_day;
            $service->extra_day = $request->extra_day;
            $service->extra_day_start_time = $request->extra_day_start_time;
            $service->extra_day_end_time = $request->extra_day_end_time;
            $service->user_id = Auth::id();

            if ($request->file()) {
                $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                $request->file('image')->move(public_path('uploads/lawyer/service'), $imageName);
                $service->cover_image = $imageName;
            }
            $service->save();

            $this->make_time_slots(Auth::id(), $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

            return redirect()->route('lawyer.service.list')->with('message', 'Service Added Successfully');
        }
    }

    public function make_time_slots($user_id, $service_id, $req_start_time, $req_end_time, $req_extra_day_start_time, $req_extra_day_end_time)
    {
        $time_spans = LawyersTimeSpan::where('user_id', $user_id)->where('service_id', $service_id)->delete();
        $start_time = Carbon::createFromFormat('H:i', $req_start_time);
        $end_time = Carbon::createFromFormat('H:i', $req_end_time);
        $slot_duration = 15;
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
