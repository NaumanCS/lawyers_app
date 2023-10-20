<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $credentials = ['phone' => $request->phone, 'password' => $request->password];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'lawyer') {
                return redirect()->route('lawyer.dashboard');
            } else if ($user->role == 'user') {
                return redirect()->route('customer.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors('You have entered an invalid email/password, Please try again');
            }
        } else {
            return redirect()->back()->withErrors('You have entered an invalid email/password, Please try again');
        }
    }
}
