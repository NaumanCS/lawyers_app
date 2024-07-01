<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerifyToken;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;

class UsersLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_page()
    {

        return view('front-layouts.pages.auth.login', get_defined_vars());
    }

    public function login(Request $request)
    {

        // $user = Users::where('email',$request->email)->where('role','business')->where('status',0)->count();
        // if($user > 0){
        //     return redirect()->back()->withErrors('Your account is blocked, please check your email for details.');
        // }

        $credentials = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'lawyer' && $request->user_type == 'lawyer' && $request->user_type == 'lawyer') {
                return redirect()->route('lawyer.dashboard');
            } else if ($user->role == 'user' || $user->role == 'lawyer') {
                if ($request->user_type == 'user') {
                    return redirect()->route('customer.dashboard');
                }
                Auth::logout();
                return redirect()->back()->withErrors('You can not access as '. $request->user_type);
            } else {
                Auth::logout();
                return redirect()->back()->withErrors('You have entered an invalid email/password, Please try again');
            }
        } else {
            return redirect()->back()->withErrors('You have entered an invalid email/password, Please try again');
        }
    }


    // password reset
    public function forgot_password()
    {

        return view('front-layouts.pages.auth.passwords.reset', get_defined_vars());
    }
    public function otp()
    {

        return view('front-layouts.pages.auth.passwords.otp', get_defined_vars());
    }
    public function confirm_password()
    {

        return view('front-layouts.pages.auth.passwords.confirm', get_defined_vars());
    }

    public function send_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users'
        ]);
        session()->put('email', $request->email);
        // requestValidate($request, [
        //     "email" => "required|email|exists:users"

        // ]);
        if ($validator->fails()) {
            return back();
        } else {
            VerifyToken::where('email', $request->email)->delete();
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $otp = rand(111111, 999999);
                VerifyToken::insert([
                    'email' => $user->email,
                    'otp' => $otp
                ]);

                // $userPhone = '+92' . ltrim($user->phone, '0');
                // $message = "Your OTP is" . $otp;


                // $account_sid = getenv("TWILIO_SID");
                // $auth_token = getenv("TWILIO_TOKEN");
                // $twilio_number = getenv("TWILIO_FROM");

                // $client = new Client($account_sid, $auth_token);
                // $client->messages->create($userPhone, [
                //     'from' => $twilio_number,
                //     'body' => $message
                // ]);

                $from = getenv("MAIL_FROM_ADDRESS");


                Mail::send('front-layouts.pages.emails.otp-email', ['user' => $user, 'token' => $otp, 'from' => $from], function ($m) use ($user, $otp, $from) {
                    $m->from($from, 'Al-Wakeel');

                    $m->to($user->email, $user->name)->subject('Forgot Password Otp');
                });

                // return ['status' => true, 'message' => 'OTP has been sent on your Email please check your inbox, also check spam list'];

                return redirect('/otp');
            } else {

                return back()->withErrors(['email' => "The Phone you provided doesn't belong to any account"]);
            }
        }
    }

    public function resend_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|phone|exists:users'
        ]);
        session()->put('email', $request->email);

        VerifyToken::where('phone', $request->phone)->delete();
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $otp = rand(111111, 999999);
            VerifyToken::insert([
                'phone' => $user->phone,
                'token' => $otp
            ]);
            $userPhone = '+92' . ltrim($user->phone, '0');
            $message = "Your OTP is" . $otp;


            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($userPhone, [
                'from' => $twilio_number,
                'body' => $message
            ]);
            // Mail::send('emails.verification', ['user' => $user, 'otp' => $otp], function ($m) use ($user, $token) {
            //     $m->from('info@dwive758.com', 'medullaEffect');

            //     $m->to($user->otp, $user->name)->subject('Forgot Password otp');
            // });

            return back();
        } else {

            return back();
        }
    }

    function verify_otp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "otp" => "required",
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['otp' => "The otp you provided is incorrect "]);
        } else {
            $requestToken = $request->otp;
            $otp = VerifyToken::where('otp', $requestToken)->first();

            if (isset($otp)) { // Check if $otp is not null
                $userEmail = User::where('email', $otp->email)->first();
                $userEmail->update([
                    'otp_verified' => 1,
                ]);
                if ($userEmail) {
                    VerifyToken::where('otp', $request->otp)->delete();

                    return view('front-layouts.pages.auth.passwords.confirm', compact('userEmail'));
                } else {
                    return back()->withErrors(['message' => "Invalid OTP"]);
                }
            } else {
                return back()->withErrors(['message' => "Invalid OTP"]);
            }
            // return view('auth.forgotPassword.resetPassword', get_defined_vars());


        }
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            "password" => "required"
        ]);
        $userEmail = User::where('email', $request->email)->first();

        if ($userEmail->otp_verified == 1) {
            $result = User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);
            if (isset($result) && !empty($result)) {
                $userEmail->update([
                    'otp_verified' => null,
                ]);
                return redirect('/login/page');
            } else {
                return redirect('/confirm/password');
            }
        } else {
            // dd('ok');
            return redirect('/confirm/password');
        }
    }
}
