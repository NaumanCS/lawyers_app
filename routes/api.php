<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Chat\ChatController;
use App\Http\Controllers\Api\Customer\CustomerController;
use App\Http\Controllers\Api\Frontend\FrontController;
use App\Http\Controllers\Api\Lawyer\LawyerController;
use App\Http\Controllers\Api\Meeting\MeetingController;
use App\Http\Controllers\Api\Notification\NotificationController;
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

Route::post('send/otp', [AuthController::class, 'send_otp'])->name('send.otp');
Route::post('resend/otp', [AuthController::class, 'resend_otp'])->name('resend.otp');
Route::post('verify/otp', [AuthController::class, 'verify_otp'])->name('verify.otp');

Route::post('reset/password', [AuthController::class, 'reset_password'])->name('reset.password');


Route::get('categories', [FrontController::class, 'categories']);
Route::get('category/lawyer/{id?}/{perpage?}/{page?}', [FrontController::class, 'category_lawyers']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('lawyer/list', [CustomerController::class, 'lawyer_list']);
Route::get('city/list', [CustomerController::class, 'city_list']);
Route::get('cities', [FrontController::class, 'cities']);
Route::get('setting', [FrontController::class, 'setting']);

// help center
Route::post('/help/center/submit', [FrontController::class, 'help_center_submit']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('meeting/status',[MeetingController::class, 'meeting_status']);

    Route::get('chat', [ChatController::class, 'chat']);
    Route::get('/create/chat/room/{lawyerId}', [ChatController::class, 'create_chat_room']);
    Route::get('display-rooms', [ChatController::class, 'get_rooms']);
    Route::get('display-single-chat/{roomId}', [ChatController::class, 'single_chat']);
    Route::post('/send/new/message', [ChatController::class, 'send_message']);
    Route::get('/fetch-chats', [ChatController::class, 'fetch_new_messages']);

    Route::middleware(['customer', 'blockedUser'])->group(function () {
        Route::get('/customer/dashboard', [CustomerController::class, 'index']);

        // LAwyers

        Route::get('lawyer/profile/{id}', [CustomerController::class, 'lawyer_profile'])->name('lawyer.profile');

        // user profile
        Route::get('customer/profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
        Route::post('customer/profile/update', [CustomerController::class, 'customerProfileUpdate'])->name('customer.profile.update');

        Route::get('select-date-and-time-span/{id}', [CustomerController::class, 'select_date_and_time_span']);
        Route::post('/book/service/{id?}', [CustomerController::class, 'book_service']);


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


    // LAWYER PART
    Route::middleware(['auth', 'lawyer', 'blockedUser'])->group(function () {
        Route::get('/lawyer/dashboard', [LawyerController::class, 'index']);

        Route::get('/lawyer/documents/verification', [LawyerController::class, 'document_verification']);
        Route::post('/lawyer/documents/update', [LawyerController::class, 'documents_update']);

        Route::get('/lawyer/profile', [LawyerController::class, 'profile']);
        Route::post('/lawyer/profile/update', [LawyerController::class, 'profile_update']);
        Route::post('/lawyer/account/update', [LawyerController::class, 'lawyer_account_update']);

        // Services Crud
        Route::get('/lawyer/service/list', [LawyerController::class, 'service_list']);
        Route::get('/lawyer/service/edit/{id}', [LawyerController::class, 'edit_service']);
        Route::post('/lawyer/service/update', [LawyerController::class, 'update_service']);


        // Orders Crud
        Route::get('lawyer/orders/all', [LawyerController::class, 'all_orders']);
        Route::post('/lawyer/order/status', [OrderController::class, 'lawyer_order_status'])->name('lawyer.order.status');
        Route::get('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

        // Earnings Crud
        Route::get('/lawyer/wallet', [LawyerController::class, 'lawyer_wallet']);

        // meeting Schedule
        Route::get('lawyer/meeting/list', [LawyerController::class, 'lawyer_meeting_list']);
    });

    Route::get('all/notifications', [NotificationController::class, 'all_notifications']);
    Route::get('/notifications/{notification}', [NotificationController::class, 'markAsRead']);
});



//PAYMOB
Route::post('checkout/processed', [PayMobController::class, 'checkout_processed']);
