<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CreateMeeting;
use App\Models\Order;
use App\Models\User;
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
        $order=Order::where('customer_id',auth()->user()->id)->get();
        if($order){
            $allOrder=$order->count();

            $pendingOrder=$order->filter(function ($order) {
                return $order->status === 'pending' || $order->status === 0 || $order->status== null;
            })->count();
            $completedOrders = $order->filter(function ($order) {
                return $order->status == 'completed' || $order->status == 1;
            })->count();

        }
        return view('front-layouts.pages.customer.dashboard',get_defined_vars());
    }

    // lawyers
    public function lawyer_list()
    {
        $lawyers = User::where('role', 'lawyer')->lawyerApproved()->get();
        $meetings = CreateMeeting::where('created_by', auth()->user()->id)->with('spanTime', 'user')->get();
      
        return view('front-layouts.pages.customer.lawyers.index', get_defined_vars());
    }

    public function lawyer_profile($id)
    {
        $lawyerProfile = User::where('id', $id)->first();
        return view('front-layouts.pages.customer.lawyers.profile', get_defined_vars());
    }

    public function customerProfile()
    {
        $auth = auth()->user()->id;
        $customerProfile = User::where('id', $auth)->first();
        return view('front-layouts.pages.customer.profile', get_defined_vars());
    }


    
    public function customerProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
    
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
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
    
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
}
