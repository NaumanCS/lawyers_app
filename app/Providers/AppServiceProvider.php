<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function($view){
            $user = Auth::user();
            $view->with('user' , $user);
        });

        view()->composer('front-layouts.partials.navbar', function ($view) {
            $category = Category::get();
            $view->with('categories', $category);
        });

        view()->composer('front-layouts.partials.lawyer-navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notifications = $user->notifications;
 
                $view->with('notifications', $notifications);
            }
        });
    }
}
