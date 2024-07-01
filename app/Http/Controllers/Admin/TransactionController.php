<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PaymentNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yoeunes\Toastr\Facades\Toastr;

class TransactionController extends Controller
{
    //  Transaction
    public function transaction_index()
    {
        $obj = Transaction::get();
        return view('layouts.pages.transaction.index', get_defined_vars());
    }
    public function transaction_pending()
    {
        $obj = Order::where('payment_status',null)->orWhere('payment_status','pending')->with('lawyer')->get();
        return view('layouts.pages.transaction.pending', get_defined_vars());
    }
    public function transaction_form($id)
    {
        $title = 'New Transaction';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Transaction::whereId($id)->first();
        }

        return view('layouts.pages.transaction.create', get_defined_vars());
    }

    public function transaction_store(Request $req, $id)
    {

        $imageUpdateId = $id;
        if (isset($id) && !empty($id)) {
            $obj = Transaction::whereId($id)->update([
                'order_id' => $req->order_id,
                'user_id' => $req->user_id,
                'payment_id' => $req->payment_id,
                'transaction_type' => $req->transaction_type,
                'amount' => $req->amount,
                'date' => $req->date,
                'status' => $req->status,

            ]);

            return redirect(route('admin.general.setting.index'));
        } else {
            //Create
            $obj = Transaction::create([
                'order_id' => $req->order_id,
                'user_id' => $req->user_id,
                'payment_id' => $req->payment_id,
                'transaction_type' => $req->transaction_type,
                'amount' => $req->amount,
                'date' => $req->date,
                'status' => $req->status,
            ]);
            $imageUpdateId = $obj->id;
        }

        return redirect(route('admin.general.setting.index'));
    }

    public function transaction_detail($id)
    {
        $title = 'Transaction Detail';
        $transaction = Transaction::where('id', $id)->first();
        return view('layouts.pages.transaction.detail', get_defined_vars());
    }

    public function transaction_delete(Request $req)
    {

        $delete = Transaction::destroy($req->id);


        if ($delete == 1) {
            $success = true;
            $message = "Transaction deleted successfully";
        } else {
            $success = true;
            $message = "Transaction not found";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    // PAY NOW
    public function pay_now()
    {
        $payNow = Order::where('status', 'completed')->whereNot('payment_status','completed')
            ->orWhere('payment_status',null)->with('lawyer.accountDetail')
            ->select('lawyer_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('lawyer_id')
            ->get();
        // dd($payNow);
        return view('layouts.pages.transaction.payNow', get_defined_vars());
    }

    public function send_paymnet(Request $request)
    {
       
        $orders = Order::where('lawyer_id', $request->lawyer_id)->where('status', 'completed')->get();
        foreach ($orders as $order) {
            $order->update([
                'payment_status' => 'completed',
            ]);

            $currentDate= Carbon::now()->toDateString();
            // dd($currentDate);
            $transactions = Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->lawyer_id,
                'amount' => $order->amount - ($order->amount * 0.2),
                'date' => $currentDate,
                'status' =>'completed',
            ]);

            $transactionId=$transactions->id;
            $transactionId = Transaction::find($transactionId);
            $orderId = $transactionId->order_id;
        $lawyer = User::find($order->lawyer_id);
                    if ($lawyer) {
                        $lawyer->notify(new PaymentNotification($order,$orderId));
                    } else {
                        return back()->with('message', 'Lawyer Id not found');
                    }
        }

      
        Toastr::success('Payment Send Successfully.');
        return redirect()->back();
    }
}
