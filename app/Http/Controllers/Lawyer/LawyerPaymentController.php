<?php

namespace App\Http\Controllers\lawyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;

class LawyerPaymentController extends Controller
{
   public function lawyer_wallet()
   {
      $wallet = Order::where('lawyer_id', auth()->user()->id)->get();
      $completedPayment = $wallet->where('payment_status', 'completed')->sum('amount');
      $pendingPayment = $wallet->where('payment_status', '!=', 'completed')->sum('amount');
      $totalPayment = $pendingPayment + $completedPayment;
      return view('front-layouts.pages.lawyer.wallet.list', get_defined_vars());
   }
}
