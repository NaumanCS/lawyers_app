<?php

namespace App\Http\Controllers\lawyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    public function index()
    {
        $card_heading = 'All Orders';
        $data = Order::where('lawyer_id', Auth::id())->with('customer','category')->get();
        return view('front-layouts.pages.lawyer.orders.all_orders', get_defined_vars());
    }

    public function lawyer_order_status(Request $request)
    {
        $status = $request->input('status');
        $updateOrderStatus = Order::where('id', $request->order_id)->first();

        if ($updateOrderStatus) {
            $updateOrderStatus->customer_status = $status;
            $updateOrderStatus->save();

            return redirect()->back()->with('success', 'Order status updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update order status.');
        }
    }
}
