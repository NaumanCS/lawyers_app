<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'You do not have access to this page');
        }

        $user = Auth::user();

        if ($user->role == 'user' || $user->role == 'lawyer') {
            return $next($request);
        } else if ($user->role == "lawyer" || $user->role == "admin") {
            return redirect()->back()->with('error', 'You do not have access to this page');
        } else {
            Auth::logout();
            return redirect('/');
        }
    }
}
