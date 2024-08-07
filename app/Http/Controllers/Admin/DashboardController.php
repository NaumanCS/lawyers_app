<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\Category;
use App\Models\CreateMeeting;
use App\Models\feedBack;
use App\Models\GeneralSetting;
use App\Models\LawyersTimeSpan;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Notifications\OrderApproved;
use App\Notifications\OrderRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yoeunes\Toastr\Facades\Toastr;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('layouts.pages.dashboard');
    }

    // users
    public function allUsers()
    {
        $allUsers = User::whereNot('id', auth()->user()->id)
        ->with('lawyerCategory.category', 'lawyerTotalRating')
        ->withCount(['lawyerTotalRating as totalRating' => function ($query) {
            $query->select(DB::raw('coalesce(sum(rating), 0)'));
        }])
        ->orderByDesc('totalRating')
        ->get();
        // dd($allUsers);
        return view('layouts.pages.user.index', get_defined_vars());
    }

    //  CATEGORY
    public function category_index()
    {
        $obj = Category::get();
        return view('layouts.pages.category.index', get_defined_vars());
    }
    public function category_form($id)
    {
        $title = 'New Category';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Category::whereId($id)->first();
        }

        return view('layouts.pages.category.create', get_defined_vars());
    }

    public function category_store(Request $req, $id)
    {
        $imageUpdateId = $id;

        if (isset($id) && !empty($id)) {
            $obj = Category::whereId($id)->update([
                'title' => $req->title,
            ]);

           
        } else {
            //Create
            $obj = Category::create([
                'title' => $req->title,

            ]);
            $imageUpdateId = $obj->id;
           
        }
        if ($req->file()) {
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/user'), $imageName);
            Category::whereId($imageUpdateId)->update([
                'image' => $imageName
            ]);
        }
        return redirect(route('category.index'));
    }

    public function category_detail($id)
    {
        $title = 'Category Detail';
        $jobDetail = Category::where('id', $id)->first();
        return view('layouts.pages.category.detail', get_defined_vars());
    }

    public function category_delete(Request $req)
    {

        $delete = Category::destroy($req->id);
        if ($delete == 1) {
            $success = true;
            $message = "Category deleted successfully";
        } else {
            $success = true;
            $message = "Category not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    //  Services
    public function service_index()
    {
        $obj = Service::with('user', 'category')->get();
        return view('layouts.pages.service.index', get_defined_vars());
    }
    public function service_form($id)
    {
        $title = 'New service';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Service::whereId($id)->first();
        }

        return view('layouts.pages.service.create', get_defined_vars());
    }

    public function service_store(Request $req, $id)
    {

        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            $obj = Service::whereId($id)->update([
                'title' => $req->title,
            ]);

            return redirect(route('service.index'));
        } else {
            //Create
            $obj = Service::create([
                'title' => $req->title,

            ]);
            $imageUpdateId = $obj->id;
        }
        if ($req->file()) {
            $imageName = time() . '.' . $req->image->extension();
            $req->image->move(public_path('uploads/user'), $imageName);
            Service::whereId($imageUpdateId)->update([
                'image' => $imageName
            ]);
        }
        return redirect(route('service.index'));
    }

    public function service_detail($id)
    {
        $title = 'service Detail';
        $jobDetail = Service::where('id', $id)->first();
        return view('layouts.pages.service.detail', get_defined_vars());
    }

    public function service_delete(Request $req)
    {

        $delete = Service::destroy($req->id);


        if ($delete == 1) {
            $success = true;
            $message = "service deleted successfully";
        } else {
            $success = true;
            $message = "service not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    // ORDERS
    public function order_index()
    {
        $obj = Order::with('customer','lawyer')->get();
        return view('layouts.pages.orders.index', get_defined_vars());
    }
    public function order_form($id)
    {
        $title = 'New order';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Order::whereId($id)->first();
        }

        return view('layouts.pages.orders.create', get_defined_vars());
    }

    public function order_store(Request $req, $id)
    {

        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            $obj = Order::whereId($id)->update([
                'lawyer_id' => $req->lawyer_id,
                'customer_id' => $req->customer_id,
                'category_id' => $req->category_id,
                'amount' => $req->amount,
                'booking_date' => $req->booking_date,
                'lawyer_status' => $req->lawyer_status,
                'customer_status' => $req->customer_status,
                'lawyer_location' => $req->lawyer_location,
                'customer_location' => $req->customer_location,

            ]);

            return redirect(route('admin.order.index'));
        } else {
            //Create
            $obj = Order::create([
                'lawyer_id' => $req->lawyer_id,
                'customer_id' => $req->customer_id,
                'category_id' => $req->category_id,
                'amount' => $req->amount,
                'booking_date' => $req->booking_date,
                'lawyer_status' => $req->lawyer_status,
                'customer_status' => $req->customer_status,
                'lawyer_location' => $req->lawyer_location,
                'customer_location' => $req->customer_location,

            ]);
            $imageUpdateId = $obj->id;
        }

        return redirect(route('admin.order.index'));
    }

    public function order_detail($id)
    {
        $title = 'Order Detail';
        $orderDetail = Order::where('id', $id)->first();
        // dd($orderDetail);
        return view('layouts.pages.orders.detail', get_defined_vars());
    }

    public function order_delete(Request $req)
    {

        $delete = Order::destroy($req->id);


        if ($delete == 1) {
            $success = true;
            $message = "Order deleted successfully";
        } else {
            $success = true;
            $message = "Order not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function admin_order_status($orderId=null ,$status=null)
    {
            $orderStatus = Order::find($orderId);
           
            $user=User::where('id',$orderStatus->lawyer_id)->first();
           
            $orderStatus->status = $status;
            $orderStatus->save();
            $order=$orderStatus;

            if($status == 'approved'){
            $order->lawyer->notify(new OrderApproved($order, $user));
            }
            return redirect()->route('admin.order.index')->with('message', 'Order status changed successfully');

    }
    public function add_transaction_id(Request $req, $id)
    {  
        $check=Order::where('transaction_id',$req->transaction_id)->first();
        if($check){
            Toastr::error('Dublicate TransactionID.');
            return redirect(route('admin.order.index'));  
        }else{
            $obj = Order::whereId($id)->update([
                'transaction_id' => $req->transaction_id,
            ]);
            Toastr::success('TransactionID Added Successfuly.');
            return redirect(route('admin.order.index'));  
        }
            
    }

    public function reject_order (Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rejection_reason' => 'required|string|max:255',
        ]);

        $order = Order::find($request->order_id);
        $order->status = 'rejected';
        $order->rejection_reason = $request->rejection_reason;
        $order->save();

        $user=User::where('id',$order->customer_id)->first();

        // Notify the customer
        // $from = getenv("MAIL_FROM_ADDRESS","alwakeel@alwakeel.thessenterprises.com");


       
        if ($order && $user) {
            $order->customer->notify(new OrderRejectedNotification($order, $user));
           
            DB::beginTransaction();

            try {
                // Find the meeting associated with the order
                $meeting = CreateMeeting::where('order_id', $order->id)->first();
        
                if ($meeting) {
                    // Find the time span associated with the meeting
                    $timeSpan = LawyersTimeSpan::where('id', $meeting->select_time_span)->first();
        
                    if ($timeSpan) {
                        // Nullify the booked column
                        $timeSpan->update(['booked' => null]);
                    }
        
                    // Delete the meeting
                    $meeting->delete();
                }
        
                DB::commit();
                return redirect()->back()->with('success', 'Order rejected and customer notified.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Order or user not found.');
            }
          
        } else {
            // Handle if $order or $user is null
            return redirect()->back()->with('error', 'Order or user not found.');
        }
       
    }


    //  General Setting
    public function general_setting_index()
    {
        $obj = GeneralSetting::get();
        return view('layouts.pages.generalSetting.index', get_defined_vars());
    }
    public function general_setting_form($id)
    {
        $title = 'New General Setting';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = GeneralSetting::whereId($id)->first();
        }

        return view('layouts.pages.generalSetting.create', get_defined_vars());
    }

    public function general_setting_store(Request $req, $id)
    {

        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            $obj = GeneralSetting::whereId($id)->update([
                'title' => $req->title,
                'description' => $req->description,
            ]);

           
        } else {
            //Create
            $obj = GeneralSetting::create([
                'title' => $req->title,
                'description' => $req->description,
            ]);
            $imageUpdateId = $obj->id;
        }
        if ($req->file('nav_logo')) {
            $navLogo = time() .   rand(9, 999)  . $req->nav_logo->extension();
            $req->nav_logo->move(public_path('uploads/user'), $navLogo);
            GeneralSetting::whereId($imageUpdateId)->update([
                'nav_logo' => $navLogo
            ]);
        }

        if ($req->file('footer_logo')) {
            $footerLogo = time() .   rand(9, 999)  . $req->footer_logo->extension();
            $req->footer_logo->move(public_path('uploads/user'), $footerLogo);
            GeneralSetting::whereId($imageUpdateId)->update([
                'footer_logo' => $footerLogo
            ]);
        }
        return redirect(route('admin.general.setting.index'));
    }

    public function general_setting_detail($id)
    {
        $title = 'General Setting Detail';
        $generalSetting = GeneralSetting::where('id', $id)->first();
        return view('layouts.pages.generalSetting.detail', get_defined_vars());
    }

    public function general_setting_delete(Request $req)
    {

        $delete = GeneralSetting::destroy($req->id);


        if ($delete == 1) {
            $success = true;
            $message = "General setting deleted successfully";
        } else {
            $success = true;
            $message = "General setting not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }


    // User Accounts
    public function user_accounts_index()
    {
        $obj = AccountDetail::with('user')->get();
        return view('layouts.pages.userAccounts.index', get_defined_vars());
    }
   

    public function user_accounts_detail($id)
    {
        $title = 'User Account Detail';
        $userAccountDetail = AccountDetail::where('id', $id)->with('user')->first();
        // dd($orderDetail);
        return view('layouts.pages.orders.detail', get_defined_vars());
    }

    public function user_accounts_delete(Request $req)
    {

        $delete = AccountDetail::destroy($req->id);


        if ($delete == 1) {
            $success = true;
            $message = "Order deleted successfully";
        } else {
            $success = true;
            $message = "Order not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function admin_user_accounts_status($orderId=null ,$status=null)
    {
            $orderStatus = AccountDetail::find($orderId);
            $orderStatus->status = $status;
            $orderStatus->save();
    
            return redirect()->route('admin.order.index')->with('message', 'Order status changed successfully');
     
    }
}
