<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\JitsiVideoCallController;
use App\Http\Controllers\PayMobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */


//  Route::post('login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/customer', [AuthController::class, 'register_customer']);
Route::post('/register/lawyer', [AuthController::class, 'register_lawyer']);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::middleware(['customer', 'blockedUser'])->group(function () {
        Route::get('/customer/dashboard', [CustomerController::class, 'index']);

        // LAwyers
        Route::get('lawyer/list', [CustomerController::class, 'lawyer_list'])->name('lawyer.list');
        Route::get('lawyer/profile/{id}', [CustomerController::class, 'lawyer_profile'])->name('lawyer.profile');

        // user profile
        Route::get('customer/profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
        Route::post('customer/profile/update', [CustomerController::class, 'customerProfileUpdate'])->name('customer.profile.update');

        Route::get('book/service/{id}', [CheckOutController::class, 'book_service'])->name('book.service');


        Route::get('/order/index', [CustomerController::class, 'order_index']);
        Route::get('/order/form/{id}', [CustomerController::class, 'order_form'])->name('order.form');
        Route::post('/order/store/{id}', [CustomerController::class, 'order_store']);
        Route::get('/order/detail/{id}', [CustomerController::class, 'order_detail'])->name('order.details');
        Route::post('/order/delete/{id}', [CustomerController::class, 'order_delete'])->name('order.delete');
        // update order status
        Route::post('/order/status', [CustomerController::class, 'order_status'])->name('order.status');

        // Meeting Schedule
        Route::get('meeting/schedule/list', [CustomerController::class, 'meeting_schedule_list']);
        Route::get('meeting/schedule/{id}', [JitsiVideoCallController::class, 'meeting_schedule_create'])->name('meeting.schedule.create');
        Route::post('meeting/schedule/store', [JitsiVideoCallController::class, 'meeting_schedule_store'])->name('meeting.schedule.store');

        // feedback
        Route::post('feedback/store', [FeedBackController::class, 'feedback_store'])->name('feedback.store');
        // routes/web.php

        Route::post('/delete-meeting/{meetingId}', [FeedBackController::class, 'deleteMeeting'])->name('delete-meeting');
    });
});

//PAYMOB
Route::post('checkout/processed', [PayMobController::class, 'checkout_processed']);
