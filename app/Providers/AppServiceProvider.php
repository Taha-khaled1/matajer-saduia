<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('layouts.main-header', function ($view) {
            $setting = Setting::where('isadmin', 1)->select('logo')->first();
            $notifications = Auth::user()->notifications;
            $countNotifications = Auth::user()->unreadnotifications->count();
            $view->with(['company_data' => $setting, "notifications" => $notifications, "countNotifications" => $countNotifications]);
        });


        view()->composer('layouts.main-sidebar', function ($view) {
            $setting = Setting::where('isadmin', 1)->select('logo')->first();
            $view->with('company_data', $setting);
        });
    }
}
