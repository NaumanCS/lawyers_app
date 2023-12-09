<?php

use App\Http\Controllers\Auth\UsersLoginController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\VerificationController;
use App\Http\Controllers\AgoraVideoController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;

// ==============> Admin Controllers Starts
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\Admin\VerificationController;
// use App\Http\Controllers\Admin\TransactionController;
// ==============> Admin Controllers Ends

// ==============> Customer Controllers Starts
use App\Http\Controllers\Auth\CustomerRegisterController;
// use App\Http\Controllers\Customer\OrderController;
// use App\Http\Controllers\Customer\CustomerController;
// ==============> Customer Controllers Ends

// ==============> Lawyers Controller Starts
use App\Http\Controllers\Auth\LawyerRegisterController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\JitsiVideoCallController;
use App\Http\Controllers\Lawyer\LawyerController;
use App\Http\Controllers\Lawyer\ServiceController;
use App\Http\Controllers\PayMobController;
use App\Http\Controllers\Lawyer\BookingController;
use App\Http\Controllers\Lawyer\LawyerPaymentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\Notification\NotificationController;
// ==============> Lawyers Controller Ends

use App\Http\Controllers\PusherController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [FrontController::class, 'index'])->name('front');
Route::get('/blocked', [FrontController::class, 'user_blocked'])->name('blocked.users');
Route::post('/lawyer/signup', [LawyerRegisterController::class, 'create'])->name('lawyer.register');
Route::post('customer/signup', [CustomerRegisterController::class, 'create'])->name('customer.register');
// Route::post('/admin/login', [DashboardController::class, 'admin_login'])->name('admin.login');
Route::get('/login/page', [UsersLoginController::class, 'login_page'])->name('login.page');

Route::post('user/login', [UsersLoginController::class, 'login'])->name('users.login');
Route::get('/lawyer/signup', [LawyerRegisterController::class, 'index'])->name('lawyer.register.page');
Route::get('/customer/signup', [CustomerRegisterController::class, 'index'])->name('customer.register.page');


Route::get('/categories/{filter}', [FrontController::class, 'categories'])->name('categories');
Route::get('/lawyers/{category}', [FrontController::class, 'lawyers_with_category'])->name('lawyers.with.category');
Route::get('/lawyers/services/{filter}', [FrontController::class, 'lawyers_services'])->name('lawyers.services');

Route::get('/contact-us', [FrontController::class, 'contact_us'])->name('contact.us');
Route::post('/contact-us/submit', [FrontController::class, 'support_msg'])->name('contact.us.submit');
// Route::get('/chat', [PusherController::class, 'index'])->name('chat');
// Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('broadcast');
// Route::post('/receive', [PusherController::class, 'receive'])->name('receive');


Route::get('image/update', function () {
    return view('front-layouts.pages.lawyer.image-update');
});

Route::get('/search', [FrontController::class, 'search'])->name('search');

Auth::routes();
Route::get('/create/chat/room/{lawyerId}', [HomeController::class, 'create_chat_room'])->name('create.chat.room');
Route::get('chat', [HomeController::class, 'chat'])->name('chat');
Route::get('display-rooms', [HomeController::class, 'get_rooms'])->name('display.chat.rooms');
Route::get('display-single-chat/{roomId}', [HomeController::class, 'single_chat'])->name('display.single.chat');
Route::post('/send/new/message', [HomeController::class, 'send_message']);
Route::get('/fetch-new-messages', [HomeController::class, 'fetch_new_messages']);
// ADMIN PART
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/all-users', [DashboardController::class, 'allUsers'])->name('all.users');

    Route::get('/category/index', [DashboardController::class, 'category_index'])->name('category.index');
    Route::get('/category/form/{id}', [DashboardController::class, 'category_form'])->name('category.form');
    Route::post('/category/store/{id}', [DashboardController::class, 'category_store'])->name('category.store');
    Route::get('/category/detail/{id}', [DashboardController::class, 'category_detail'])->name('category.details');
    Route::post('/category/delete/{id}', [DashboardController::class, 'category_delete'])->name('category.delete');

    Route::get('/service/index', [DashboardController::class, 'service_index'])->name('service.index');
    Route::get('/service/form/{id}', [DashboardController::class, 'service_form'])->name('service.form');
    Route::post('/service/store/{id}', [DashboardController::class, 'service_store'])->name('service.store');
    Route::get('/service/detail/{id}', [DashboardController::class, 'service_detail'])->name('service.details');
    Route::post('/service/delete/{id}', [DashboardController::class, 'service_delete'])->name('service.delete');

    Route::get('admin/order/index', [DashboardController::class, 'order_index'])->name('admin.order.index');
    Route::get('admin/order/form/{id}', [DashboardController::class, 'order_form'])->name('admin.order.form');
    Route::post('admin/order/store/{id}', [DashboardController::class, 'order_store'])->name('admin.order.store');
    Route::get('admin/order/detail/{id}', [DashboardController::class, 'order_detail'])->name('admin.order.details');
    Route::post('admin/order/delete/{id}', [DashboardController::class, 'order_delete'])->name('admin.order.delete');
    Route::get('admin/order/status/{orderId?}/{status?}', [DashboardController::class, 'admin_order_status'])->name('admin.order.status');
    Route::post('admin/order/add/transaction-id/{id?}', [DashboardController::class, 'add_transaction_id'])->name('admin.add.transaction.id');

    Route::get('admin/general-setting/index', [DashboardController::class, 'general_setting_index'])->name('admin.general.setting.index');
    Route::get('admin/general-setting/form/{id}', [DashboardController::class, 'general_setting_form'])->name('admin.general.setting.form');
    Route::post('admin/general-setting/store/{id}', [DashboardController::class, 'general_setting_store'])->name('admin.general.setting.store');
    Route::get('admin/general-setting/detail/{id}', [DashboardController::class, 'general_setting_detail'])->name('admin.general.setting.details');
    Route::post('admin/general-setting/delete/{id}', [DashboardController::class, 'general_setting_delete'])->name('admin.general.setting.delete');

    Route::get('admin/transaction/index', [TransactionController::class, 'transaction_index'])->name('admin.transaction.index');
    Route::get('admin/pending/transaction', [TransactionController::class, 'transaction_pending'])->name('admin.transaction.pending');
    // Route::get('admin/transaction/form/{id}', [TransactionController::class, 'transaction_form'])->name('admin.transaction.form');
    // Route::post('admin/transaction/store/{id}', [TransactionController::class, 'transaction_store'])->name('admin.transaction.store');
    Route::get('admin/transaction/detail/{id}', [TransactionController::class, 'transaction_detail'])->name('admin.transaction.details');
    Route::post('admin/transaction/delete/{id}', [TransactionController::class, 'transaction_delete'])->name('admin.transaction.delete');

    Route::get('admin/lawyers/verifications', [VerificationController::class, 'all_verifications'])->name('admin.lawyer.verification');
    Route::get('admin/lawyer/view/doc/{id}', [VerificationController::class, 'details'])->name('admin.lawyer.view.details');
    Route::post('admin/lawyer/document/approval', [VerificationController::class, 'document_approval'])->name('admin.lawyer.document.approval');
    Route::get('admin/notify', [VerificationController::class, 'notify'])->name('admin.notify.lawyer');

    Route::get('/admin/block/user', [VerificationController::class, 'blockUser'])->name('admin.block.user');

    Route::get('admin/user/accounts/index', [DashboardController::class, 'user_accounts_index'])->name('admin.user.accounts.index');
    Route::get('admin/user/accounts/form/{id}', [DashboardController::class, 'user_accounts_form'])->name('admin.user.accounts.form');
    Route::post('admin/user/accounts/store/{id}', [DashboardController::class, 'user_accounts_store'])->name('admin.user.accounts.store');
    Route::get('admin/user/accounts/detail/{id}', [DashboardController::class, 'user_accounts_detail'])->name('admin.user.accounts.details');
    Route::post('admin/user/accounts/delete/{id}', [DashboardController::class, 'user_accounts_delete'])->name('admin.user.accounts.delete');

    // Pay Now
    Route::get('admin/pay/now', [TransactionController::class, 'pay_now'])->name('pay.now');
    Route::post('admin/send/payment', [TransactionController::class, 'send_paymnet'])->name('send.payment');

});

// ADMIN PART
// Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// LAWYER PART
Route::middleware(['auth', 'lawyer', 'blockedUser'])->group(function () {
    Route::get('/lawyer/dashboard', [LawyerController::class, 'index'])->name('lawyer.dashboard');

    Route::get('/lawyer/documents/verification', [LawyerController::class, 'document_submission'])->name('lawyer.document.verification');
    Route::post('/lawyer/documents/submit', [LawyerController::class, 'submit_documents'])->name('lawyer.documents.submit');
    Route::get('/lawyer/documents/verification/update', [LawyerController::class, 'document_submission_update'])->name('lawyer.document.verification.update');
    Route::post('/lawyer/documents/update', [LawyerController::class, 'documents_update'])->name('lawyer.documents.update');

    Route::get('/lawyer/profile/setting', [LawyerController::class, 'profile_setting'])->name('lawyer.profile.setting');
    Route::post('/lawyer/profile/submit', [LawyerController::class, 'profile_submit'])->name('lawyer.profile.submit');
    Route::post('/lawyer/account/update', [LawyerController::class, 'lawyer_account_update'])->name('lawyer.account.update');

    // Services Crud
    Route::get('/lawyer/service/list', [ServiceController::class, 'index'])->name('lawyer.service.list');
    Route::get('/lawyer/service/form/{id}', [ServiceController::class, 'create'])->name('lawyer.service.create');
    Route::post('/lawyer/service/store/{id}', [ServiceController::class, 'store'])->name('lawyer.service.store');
    Route::post('/lawyer/service/detail/{id}', [ServiceController::class, 'detail'])->name('lawyer.service.detail');
    Route::post('lawyer/service/delete/{id}', [ServiceController::class, 'delete'])->name('lawyer.service.delete');

    // Orders Crud
    Route::get('lawyer/orders/all', [BookingController::class, 'index'])->name('lawyer.all.orders');
    Route::post('/lawyer/order/status', [OrderController::class, 'lawyer_order_status'])->name('lawyer.order.status');
    Route::get('/notifications/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // Earnings Crud
    Route::get('/lawyer/wallet', [LawyerPaymentController::class, 'lawyer_wallet'])->name('lawyer.wallet');

    // meeting Schedule
    Route::get('lawyer/meeting/list', [JitsiVideoCallController::class, 'lawyer_meeting_list'])->name('lawyer_meeting_list');
});

// CUSTOMER PART
Route::middleware(['auth', 'customer', 'blockedUser'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    // LAwyers
    Route::get('lawyer/list', [CustomerController::class, 'lawyer_list'])->name('lawyer.list');
    Route::get('lawyer/profile/{id}', [CustomerController::class, 'lawyer_profile'])->name('lawyer.profile');

    // user profile
    Route::get('customer/profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
    Route::post('customer/profile/update/{user}', [CustomerController::class, 'customerProfileUpdate'])->name('customer.profile.update');

    Route::get('book/service/{id}', [CheckOutController::class, 'book_service'])->name('book.service');


    Route::get('/order/index', [OrderController::class, 'order_index'])->name('order.index');
    Route::get('/order/form/{id}', [OrderController::class, 'order_form'])->name('order.form');
    Route::post('/order/store/{id}', [OrderController::class, 'order_store'])->name('order.store');
    Route::get('/order/detail/{id}', [OrderController::class, 'order_detail'])->name('order.details');
    Route::post('/order/delete/{id}', [OrderController::class, 'order_delete'])->name('order.delete');
    // update order status
    Route::post('/order/status', [OrderController::class, 'order_status'])->name('order.status');

    // Meeting Schedule
    Route::get('meeting/schedule/list', [JitsiVideoCallController::class, 'meeting_schedule_list'])->name('meeting.schedule.list');
    Route::get('meeting/schedule/{id}', [JitsiVideoCallController::class, 'meeting_schedule_create'])->name('meeting.schedule.create');
    Route::post('meeting/schedule/store', [JitsiVideoCallController::class, 'meeting_schedule_store'])->name('meeting.schedule.store');

// feedback
Route::post('feedback/store', [FeedBackController::class, 'feedback_store'])->name('feedback.store');
// routes/web.php

Route::post('/delete-meeting/{meetingId}', [FeedBackController::class, 'deleteMeeting'])->name('delete-meeting');

});

Route::middleware(['auth'])->group(function () {
    Route::post('/payment', [StripePaymentController::class, 'payment'])->name('payment');
    Route::post('/', [StripePaymentController::class, 'call']);

    // Pay MOB
    // Route::post('/checkout', [CheckOutController::class, 'index'])->name('checkout');
    // Route::post('/pay', [CheckOutController::class, 'pay'])->name('pay');
    // Route::get('checkout/response', function (Request $request) {
    //     return $request->all();
    // });

    // Payment Method
    Route::post('/checkout', [CheckOutController::class, 'checkout'])->name('checkout');

    Route::get('/select/payment/method/{id?}', [CheckOutController::class, 'select_payment_method'])->name('select.payment.method');
    Route::get('/upload/payment/slip/{id?}', [CheckOutController::class, 'select_payment_method'])->name('upload.payment.slip');

});

Route::get('payTest/page', [PayMobController::class, 'paymobtestpage'])->name('paymob.test.page');

// Video Calling with Agora
Route::group(['middleware' => ['auth']], function () {
    Route::get('/agora-chat', [AgoraVideoController::class, 'index'])->name('agora.index');
    Route::post('/agora/token', [AgoraVideoController::class, 'token']);
    Route::post('/agora/call-user', [AgoraVideoController::class, 'callUser']);

    Route::get('/create-meeting/{lawyerId}', [AgoraVideoController::class, 'createMeeting'])->name('create.meeting');
    Route::post('/store-meeting',  [AgoraVideoController::class, 'storeMeeting'])->name('store.meeting');

    Route::post('/agora-chat-new', [AgoraVideoController::class, 'indexNew'])->name('agora.index.new');
});
 // Jitsi Vieeo call
 Route::get('jitsi/video/call/{lawyerId?}', [JitsiVideoCallController::class, 'jitsi_video_call'])->name('jitsi.video.call');
 Route::get('video/call/{meetingId}',[JitsiVideoCallController::class, 'video_call'])->name('video.call');
 Route::get('/video/call/lawyer/{meetingId}', [JitsiVideoCallController::class, 'video_call_lawyer'])->name('video.call.lawyer');
 Route::post('/store-meeting-link', [JitsiVideoCallController::class, 'storeMeetingLink'])->name('store-meeting-link');



// Route::group(['middleware' => 'lawyer'], function () {
//     Route::group(['prefix' => 'lawyer'], function () {
//         Route::get('/dashboard', [LawyerController::class, 'index'])->name('lawyer.dashboard');
//     });
// });

// Route::group(['middleware' => 'customer'], function () {
//     Route::group(['prefix' => 'customer'], function () {
//         Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
//     });
// });
