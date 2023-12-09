<?php

namespace App\Http\Controllers\Api\Customer;

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
    public function __construct()
    {
        $this->middleware('auth');
    }
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

            return response()->json(['allOrders' => $allOrder, 'pendingOrders' => $pendingOrder, 'completedOrders' => $completedOrders], 201);
        } else {
            return response()->json(['error' => 'Orders Not Found'], 500);
        }
    }

    public function customerProfile()
    {
        $auth = auth()->user()->id;
        $customerProfile = User::where('id', $auth)->first();
        return response()->json(['customerProfile' => $customerProfile], 201);
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
        return response()->json(['user' => $user], 201);
    }


    // LAWYER
    public function lawyer_list()
    {
        $lawyers = User::where('role', 'lawyer')->get();
        $meetings = CreateMeeting::where('created_by', auth()->user()->id)->with('spanTime', 'user')->get();

        return response()->json(['lawyers' => $lawyers, 'meetings' => $meetings], 201);
    }

    public function lawyer_profile($id)
    {
        $lawyerProfile = User::where('id', $id)->first();
        return response()->json(['lawyerProfile' => $lawyerProfile], 201);
    }


    // ORDERS
    public function order_index()
    {
        $obj = Order::where('customer_id', auth()->user()->id)->get();
        return response()->json(['obj' => $obj], 201);
    }

    public function order_store(Request $req, $id)
    {
        $orderDetail = session()->get('orderDetail');
        $auth = auth()->user();

        $currentDateTime = Carbon::now();
        $lawyer = User::where('id', $req->lawyer_id)->first();
        $imageUpdateId = $id;
        if ($orderDetail) {
            if (isset($id) && !empty($id)) {
                $obj = Order::whereId($id)->update([
                    'lawyer_id' => $orderDetail['lawyer_id'],
                    'customer_id' => $auth->id,
                    'category_id' => $req->category_id,
                    'amount' => $orderDetail['amount'],
                    // 'booking_date' => $req->currentDateTime,
                    'booking_date' => $orderDetail['booking_date'],
                    'lawyer_location' => $lawyer->city ?? 'no city provided',
                    'customer_location' => $auth->city ?? 'no city provided',
                ]);

                return response()->json(['message' => 'Order Updated successfully', 'obj' => $obj], 201);
            } else {
                //Create
                $obj = Order::create([
                    'lawyer_id' => $orderDetail['lawyer_id'],
                    'customer_id' => $auth->id,
                    'category_id' => $req->category_id,
                    'amount' => $orderDetail['amount'],
                    // 'booking_date' => $req->currentDateTime,
                    'booking_date' => $orderDetail['booking_date'],
                    'lawyer_location' => $lawyer->city ?? 'no city provided',
                    'customer_location' => $auth->city ?? 'no city provided',
                ]);
                $imageUpdateId = $obj->id;



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

                $meetingController = new JitsiVideoCallController();
                $lawyerId = $orderDetail['lawyer_id'];
                $date = $orderDetail['booking_date'];
                $selectTimeSpan = $orderDetail['select_time_span'];

                // Call the meeting_schedule_store function from the MeetingController
                $meetingController->meeting_schedule_store($lawyerId, $date, $selectTimeSpan, $orderId);
                $meetingController->book_time_span($selectTimeSpan, 1);

                return response()->json(['message' => 'Order Created successfully', 'obj' => $obj], 201);
            }
        }

        if ($req->file('jazzcash_slip')) {
            $paymentSlip = time() . '.' . $req->jazzcash_slip->extension();
            $req->jazzcash_slip->move(public_path('uploads/user'), $paymentSlip);
            $order = Order::whereId($imageUpdateId)->update([
                'payment_slip' => $paymentSlip
            ]);

            return response()->json(['message' => 'Payment Slip uploaded'], 201);
        }
        if ($req->file('bank_slip')) {
            $paymentSlip = time() . '.' . $req->bank_slip->extension();
            $req->bank_slip->move(public_path('uploads/user'), $paymentSlip);
            $order = Order::whereId($imageUpdateId)->update([
                'payment_slip' => $paymentSlip
            ]);

            return response()->json(['message' => 'Payment Slip uploaded'], 201);
        }
    }

    // Meeting
    public function meeting_schedule_list()
    {
        try {
            $obj = CreateMeeting::where('created_by', auth()->user()->id)->with('spanTime', 'user')->get();
    
            if ($obj->isEmpty()) {
                return response()->json(['message' => 'There are no meetings scheduled yet.'], 201);
            }
    
            return response()->json(['Meetings' => $obj], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching meeting schedule.'], 500);
        }
    }
    
}
