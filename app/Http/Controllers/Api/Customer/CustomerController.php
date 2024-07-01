<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Meeting\MeetingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\JitsiVideoCallController;
use App\Models\CreateMeeting;
use App\Models\Order;
use App\Models\User;
use App\Notifications\BookingNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $order = Order::where('customer_id', auth()->user()->id)->get();
        if ($order) {
            $allOrder = $order->count();

            $pendingOrder = $order->filter(function ($order) {
                return $order->status === 'pending' || $order->status === 0 || $order->status == null;
            })->count();
            $completedOrders = $order->filter(function ($order) {
                return $order->status == 'completed' || $order->status == 1;
            })->count();

            return response()->json(['allOrders' => $allOrder, 'pendingOrders' => $pendingOrder, 'completedOrders' => $completedOrders], 200);
        } else {
            return response()->json(['error' => 'Orders Not Found'], 500);
        }
    }

    public function customerProfile()
    {
        $auth = auth()->user()->id;
        $customerProfile = User::where('id', $auth)->first();
        return response()->json(['customerProfile' => $customerProfile], 200);
    }
    public function customerProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User Not Found'], 500);
        }

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the max size as per your requirement
        ]);

        // Update user information
        $user->update($request->all());

        if ($request->file('image')) {

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/user'), $imageName);
            $user->image = $imageName;
            $user->save();
        }
         // Create a new token for the user
    $access_token = $user->createToken($request->phone)->plainTextToken;
        return response()->json(['message' => 'profile updated successfully','data' => $user,'access_token' => $access_token], 200);
    }


    // LAWYER
   public function lawyer_list()
{
    $lawyers = User::where('role', 'lawyer')->lawyerApproved()->paginate(10);

    return response()->json(['lawyers' => $lawyers], 200);
}


    public function lawyer_profile($id)
    {
        $lawyerProfile = User::where('id', $id)->first();
        return response()->json(['lawyerProfile' => $lawyerProfile], 200);
    }

    public function city_list()
    {
        $cities = User::where('role', 'lawyer')->pluck('city')->unique()->values();
    
        return response()->json(['message' => 'List of cities','cities' => $cities], 200);
    }
    
    // book a service
    public function select_date_and_time_span($id)
    {
        $auth = auth()->user();
        $lawyerDetail = User::where('id', $id)->with('time_spans')->first();
        $checkOrder = Order::where('customer_id', $auth->id)->where('lawyer_id', $id)->first();
        if ($checkOrder !== null && $checkOrder->status != 'completed') {
            return response()->json(['error' => 'You already have booked this order'], 500);
        }

        return response()->json(['message' => 'Lawyer slots','lawyerDetail' => $lawyerDetail], 200);
    }

    public function  book_service(Request $req, $id=null)
    {
      
        $auth = auth()->user();

        $currentDateTime = Carbon::now();
        $lawyer = User::where('id', $req->lawyer_id)->first();
        $imageUpdateId = $id;
      
            if (isset($id) && !empty($id)) {
                $obj = Order::whereId($id)->update([
                    'lawyer_id' => $req['lawyer_id'],
                    'customer_id' => $auth->id,
                    'category_id' => $req->category_id,
                    'amount' => $req['amount'],
                    // 'booking_date' => $req->currentDateTime,
                    'booking_date' => $req['booking_date'],
                    'detail' => $req['detail'],
                    'lawyer_location' => $lawyer->city ?? 'no city provided',
                    'customer_location' => $auth->city ?? 'no city provided',
                ]);

                return response()->json(['message' => 'Order Updated successfully', 'obj' => $obj], 200);
            } else {
                //Create
                $obj = Order::create([
                    'lawyer_id' => $req['lawyer_id'],
                    'customer_id' => $auth->id,
                    'category_id' => $req->category_id,
                    'amount' => $req['amount'],
                    // 'booking_date' => $req->currentDateTime,
                    'booking_date' => $req['booking_date'],
                    'detail' => $req['detail'],
                    'lawyer_location' => $lawyer->city ?? 'no city provided',
                    'customer_location' => $auth->city ?? 'no city provided',
                    'status' => 'pending',
                ]);
                $imageUpdateId = $obj->id;



                // NOTIFICATION PART

                $orderId = $obj->id;
                $order = Order::find($orderId);
            
                if ($order) {
                    $lawyer = User::find($order->lawyer_id);
                    if ($lawyer) {
                        $lawyer->notify(new BookingNotification($order));
                    } else {
                        $deleteOrder = Order::where('id', $order->id)->delete();
                        return response()->json(['error' => 'Lawyer Id Not Found'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Order Id Not Found'], 500);
                }

                $meetingController = new MeetingController();
                $lawyerId = $req['lawyer_id'];
                $date = $req['booking_date'];
                $selectTimeSpan = $req['select_time_span'];

                // Call the meeting_schedule_store function from the MeetingController
                $meetingController->meeting_schedule_store($lawyerId, $date, $selectTimeSpan, $orderId);
                $meetingController->book_time_span($selectTimeSpan, 1);

                return response()->json(['message' => 'Order Created successfully', 'obj' => $obj], 200);
            }
       

        if ($req->file('jazzcash_slip')) {
            $paymentSlip = time() . '.' . $req->jazzcash_slip->extension();
            $req->jazzcash_slip->move(public_path('uploads/user'), $paymentSlip);
            $order = Order::whereId($imageUpdateId)->update([
                'payment_slip' => $paymentSlip
            ]);

            return response()->json(['message' => 'Payment Slip uploaded'], 200);
        }
        if ($req->file('bank_slip')) {
            $paymentSlip = time() . '.' . $req->bank_slip->extension();
            $req->bank_slip->move(public_path('uploads/user'), $paymentSlip);
            $order = Order::whereId($imageUpdateId)->update([
                'payment_slip' => $paymentSlip
            ]);

            return response()->json(['message' => 'Payment Slip uploaded'], 200);
        }
    }



    // ORDERS
    public function order_index()
    {
        $obj = Order::where('customer_id', auth()->user()->id)->with('lawyer')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json(['obj' => $obj], 200);
    }

    public function order_store(Request $req, $id)
    {
    
        //   $req->validate([
        //     'jazzcash_slip' => 'null|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
        // ]);

        if ($req->hasFile('payment_slip')) {
            $image = $req->file('payment_slip');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads/user'), $imageName);
            
           
            $order = Order::whereId($id)->update([
                'payment_slip' => $imageName
            ]);
            
            return response()->json([
                'success' => true,
                // 'image_url' => asset('storage/images/' . $imageName),
                  'image_url' => asset('public/uploads/user/' . $imageName),
            ]);
           
        }else {
            return response()->json([
                'success' => false,
                'message' => 'No image uploaded',
            ]);
        }
        
        // $imageUpdateId = $id;

        // if ($req->file('jazzcash_slip')) {
        //     $paymentSlip = time() . '.' . $req->jazzcash_slip->extension();
        //     $req->jazzcash_slip->move(public_path('uploads/user'), $paymentSlip);
        //     $order = Order::whereId($imageUpdateId)->update([
        //         'payment_slip' => $paymentSlip
        //     ]);

        //     return response()->json(['message' => 'Order Updated successfully'], 200);
        // }
        // if ($req->file('bank_slip')) {
        //     $paymentSlip = time() . '.' . $req->bank_slip->extension();
        //     $req->bank_slip->move(public_path('uploads/user'), $paymentSlip);
        //     $order = Order::whereId($imageUpdateId)->update([
        //         'payment_slip' => $paymentSlip
        //     ]);

        //     return response()->json(['message' => 'Order Created successfully',], 200);
        // }
    }

    // Meeting
    public function meeting_schedule_list()
    {
        try {
            $approvedOrders = Order::where([
                'customer_id' => auth()->user()->id,
                'status' => 'approved'
            ])->pluck('id')->toArray();
        
            $obj = CreateMeeting::where('created_by', auth()->user()->id)->whereIn('order_id', $approvedOrders)->with('spanTime', 'user','user.deviceToken')->orderBy('created_at', 'desc')->paginate(10);
    
            if ($obj->isEmpty()) {
                return response()->json(['message' => 'Meetings will be available after order approval.'], 200);
            }
    
            return response()->json(['Meetings' => $obj], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching meeting schedule.'], 500);
        }
    }
    
}
