<?php

namespace App\Providers;

use App\Models\Outlet;
use App\Models\Setting;
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
        view()->composer('layouts.master', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
        view()->composer('app.layouts.master', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
        view()->composer('layouts.auth', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
        view()->composer('app.layouts.auth', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
        view()->composer('auth.login', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
        view()->composer('app.auth.login', function ($view) {
            $view->with(['setting' => Setting::first(), 'outlet' => Outlet::defaultOutlet()]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
