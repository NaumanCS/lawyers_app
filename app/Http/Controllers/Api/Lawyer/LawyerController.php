<?php

namespace App\Http\Controllers\Api\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\Category;
use App\Models\CreateMeeting;
use App\Models\LawyersTimeSpan;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LawyerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->document_status == 'approved') {
            $order = Order::where('lawyer_id', Auth::id())->count();
            $service = Service::where('user_id', Auth::id())->count();
            $earning = Order::where('lawyer_id', Auth::id())
                ->where('status', 'completed')
                ->subtractTwentyPercent()
                ->value('earning');


            return response()->json([
                'status' => 'success',
                'message' => 'User authenticated and document approved',
                'data' => [
                    'service_count' => $order,
                    'booking_count' => $service,
                    'earning_count' => $earning
                ]
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Document not approved',
                'redirect_url' => route('lawyer.document.verification')
            ], 403); // 403 Forbidden status code
        }
    }

    public function document_verification()
    {
        $user = Auth::user();

        if ($user->document_status == 'approved') {
            return response()->json([
                'status' => 'success',
                'message' => 'Document already approved',
                'redirect_url' => route('lawyer.dashboard')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Document not approved',
                'data' => [
                    $user
                ]
            ],200);
        }
    }

    public function documents_update(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        if ($request->hasFile('qualification_certificate')) {
            $qualification = rand(0, 9999) . time() . '.' . $request->file('qualification_certificate')->extension();
            $request->file('qualification_certificate')->move(public_path('uploads/lawyer/documents'), $qualification);
            $user->qualification_certificate = $qualification;
        }
        if ($request->hasFile('advocate_licence')) {
            // $advocate_licence = time() . '.' . $request->advocate_licence->extension();
             $advocate_licence = time() . '.' . $request->advocate_licence->extension();
            $request->file('advocate_licence')->move(public_path('uploads/lawyer/documents'), $advocate_licence);
            $user->advocate_licence = $advocate_licence;
        }
        if ($request->hasFile('high_court_licence')) {
            $high_court_licence =time() . '.' . $request->high_court_licence->extension();
            $request->file('high_court_licence')->move(public_path('uploads/lawyer/documents'), $high_court_licence);
            $user->high_court_licence = $high_court_licence;
        }
        if ($request->hasFile('supreme_court_licence')) {
            $supreme_court_licence = time() . '.' . $request->supreme_court_licence->extension();
            $request->file('supreme_court_licence')->move(public_path('uploads/lawyer/documents'), $supreme_court_licence);
            $user->supreme_court_licence = $supreme_court_licence;
        }
        $user->document_status='pending';
        $user->reason='';
        $user->update();

        return response()->json([
            'status' => 'success',
            'message' => 'Your Documents are updated successfully',
            'data' => [
                $user
            ]
        ],200);
    }

    // PROFILE SETTING

    public function profile()
    {
        $auth = Auth::user()->id;
        $user = User::where('id', $auth)->with('accountDetail')->first();
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ],200);
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name' => "required|string|min:3",
            'email' => "required|email|unique:users,email," . Auth::user()->id,
            'phone' => "required|regex:/^[0-9]{10,}$/",
            'city' => "required|string",
        ]);

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->postal_code = $request->input('postal_code');

        if ($request->hasFile('image')) {
            $imageName = rand(0, 9999) . time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/user'), $imageName);
            $user->image = $imageName;
        }
        $user->update();

        return response()->json([
            'status' => 'success',
            'message' => 'Your data is updated successfully',
            'data' => [
                $user
            ]
        ],200);
    }

    public function lawyer_account_update(Request $request)
    {
        $lawyerAccount = AccountDetail::where('user_id', $request->lawyer_id)->first();

        if ($lawyerAccount) {
            $lawyerAccount->update($request->except('_token', 'bank_account', 'jazzcash_account'));

            if ($request->bank_account != null) {
                $lawyerAccount->bank_account = '1';
            }

            if ($request->jazzcash_account != null) {
                $lawyerAccount->jazzcash_account = '1';
            }
        } else {
            $lawyerAccount = AccountDetail::create($request->except('_token', 'user_id', 'user_type'));
            $lawyerAccount->user_id = $request->lawyer_id;
            $lawyerAccount->user_type = 'lawyer';
            $lawyerAccount->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Your account detail is updated successfully',
            'data' => [
                $lawyerAccount
            ]
        ],200);
    }

    // MY SERVICES
    public function service_list()
    {
        $services = Service::where('user_id', Auth::id())->with('category')->get();

        return response()->json([
            'data' => $services,
            'message' => 'Services retrieved successfully',
        ],200);
    }

    public function edit_service($id)
    {
        $service = null; // Initialize $service as null
        if ($id) {
            $service = Service::where('id', $id)->with('category')->first();
        } else {
            $id = 0;
        }

        return response()->json([
            'service' => $service,
            'message' => 'Service details retrieved successfully',
        ],200);
    }

    public function update_service(Request $request)
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
        $selectedDays = $request->input('days', []);
        $selectedCategories = $request->input('categories_id', []);
        if ($selectedCategories) {
          
            // Scenario 1: Update existing service records and delete those not selected
            $lawyerCategories = Service::where('user_id', auth()->user()->id)
                ->whereIn('categories_id', $selectedCategories)
                ->get();
        
            // Update existing service records
            foreach ($lawyerCategories as $category) {
                // Update properties
                $category->title = $request->title;
                $category->location = $request->location;
                $category->amount = $request->amount;
                $category->days = $selectedDays;
                $category->start_time = $request->start_time;
                $category->end_time = $request->end_time;
                $category->user_id = Auth::id();
                $category->update();
            }
        
            // Delete service records that are not selected
            Service::where('user_id', auth()->user()->id)
                ->whereNotIn('categories_id', $selectedCategories)
                ->delete();
        
            // Scenario 2: Check for a combination of updating one service and creating another
            $existingCategoryIds = $lawyerCategories->pluck('categories_id')->toArray();
            $newCategoryIds = array_diff($selectedCategories, $existingCategoryIds);
        
            // If there are new categories to create
            foreach ($newCategoryIds as $newCategoryId) {
                // Create new service record
                $service = new Service;
                $service->title = $request->title;
                $service->location = $request->location;
                $service->amount = $request->amount;
                $service->categories_id = $newCategoryId;
                $service->days = json_encode($selectedDays);
                $service->end_day = $request->end_day;
                $service->start_time = $request->start_time;
                $service->end_time = $request->end_time;
                $service->user_id = Auth::id();
          
                // Save image if provided
                if ($request->file('cover_image')) {
                    $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                    $request->file('cover_image')->move(public_path('uploads/lawyer/service'), $imageName);
                    $service->cover_image = $imageName;
                }
        
                $service->save();
             
                // Create time slots for the new service
              
            }
           
            $this->make_time_slots(Auth::id(), $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);
        } else {
            // Scenario 3: Create new service records
            foreach ($selectedCategories as $categoryId) {
                // Create new service record
                $service = new Service;
                $service->title = $request->title;
                $service->location = $request->location;
                $service->amount = $request->amount;
                $service->categories_id = $categoryId;
                $service->start_day = $request->start_day;
                $service->end_day = $request->end_day;
                $service->start_time = $request->start_time;
                $service->end_time = $request->end_time;
                $service->add_extra_day = $request->add_extra_day;
                $service->extra_day = $request->extra_day;
                $service->extra_day_start_time = $request->extra_day_start_time;
                $service->extra_day_end_time = $request->extra_day_end_time;
                $service->user_id = Auth::id();
        
                // Save image if provided
                if ($request->file('cover_image')) {
                    $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                    $request->file('image')->move(public_path('uploads/lawyer/service'), $imageName);
                    $service->cover_image = $imageName;
                }
                
                $service->save();
        
                // Create time slots for the new service
                $this->make_time_slots(Auth::id(), $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);
            }
        }
        
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $update_id ? 'Service Updated Successfully' : 'Service Added Successfully',
                'time_slots_message' => 'Time slots created successfully',
            ],200);
        } else {
            return redirect()->route('lawyer.service.list')->with('message', $update_id ? 'Service Updated Successfully' : 'Service Added Successfully');
        }
    }

    public function make_time_slots($user_id, $req_start_time, $req_end_time, $req_extra_day_start_time, $req_extra_day_end_time)
    {
       
        // $time_spans = LawyersTimeSpan::where('user_id', $user_id)->where('service_id', $service_id)->delete();
        $time_spans = LawyersTimeSpan::where('user_id', $user_id)->delete();
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
                // 'service_id' => $service_id,
                'time_spans' => $timeSlot,
                'extra_day_time_spans' => $extraDayTimeSlots[$key] ?? null,
            ];
        }
        DB::table('lawyers_time_spans')->insert($slotsData);

        return [
            'message' => 'Time slots created successfully',
            'data' => $slotsData,
        ];
    }

    // ORDERS
    public function all_orders()
    {
        $card_heading = 'All Orders';
        $data = Order::where('lawyer_id', Auth::id())->with('customer', 'category')->select('*', DB::raw('CAST((amount - (amount * 0.20)) AS UNSIGNED) as amount'))->orderBy('created_at', 'desc')->paginate(10);
        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'All Orders',
                'orders' => $data,
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'Order not found',
            ]);
        }
    }

    // Wallet
    public function lawyer_wallet()
    {
        $order = Order::where('lawyer_id', auth()->user()->id)->select('*', DB::raw('CAST((amount - (amount * 0.20)) AS UNSIGNED) as amount'))->paginate(10);
        $completedPayment = $order->where('payment_status', 'completed')->sum('amount');
        $pendingPayment = $order->where('payment_status', '!=', 'completed')->sum('amount');
        $totalPayment = $pendingPayment + $completedPayment;
        if ($order) {
            return response()->json([
                'status' => 'success',
                'message' => 'Lawyer Wallet',
                'order' => $order,
                'completedPayment' => $completedPayment,
                'pendingPayment' => $pendingPayment,
                'totalPayment' => $totalPayment,
            ],200);
        } else {
            return response()->json([
                'status' => 'error',
                'error' => 'There is no amount for this lawyer',
            ]);
        }
    }

    // Meeting
    public function lawyer_meeting_list()
    {

        try {
            $approvedOrders = Order::where([
                'lawyer_id' => auth()->user()->id,
                'status' => 'approved'
            ])->pluck('id')->toArray();
        
            $meetings = CreateMeeting::where('meeting_with', auth()->user()->id)->whereIn('order_id', $approvedOrders)->with('spanTime', 'user','user.deviceToken')->orderBy('created_at', 'desc')->paginate(10);
    
            if ($meetings->isEmpty()) {
                return response()->json(['message' => 'Meetings will be available after order approval.'], 200);
            }
    
            return response()->json([
                'status' => 'success',
                'message' => 'All meetings',
                'meetings' => $meetings,
              
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => 'There are no meetings',
            ],500);
        }

        // $meetings = CreateMeeting::where('meeting_with', Auth::id())->with('createdByUser','spanTime','user.deviceToken')->orderBy('created_at', 'desc')->paginate(10);
        // if ($meetings->isNotEmpty()) {
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'All meetings',
        //         'meetings' => $meetings,
              
        //     ],200);
        // } else {
        //     return response()->json([
        //         'status' => 'error',
        //         'error' => 'There are no meetings',
        //     ],200);
        // }
    }
}
