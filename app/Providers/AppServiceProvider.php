<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        view()->composer(['layouts.front', 'website.index'],'App\Http\View\Composers\MenuComposer');
        view()->composer('website.faqs','App\Http\View\Composers\MenuComposer');
        view()->composer('admin.dashboard','App\Http\View\Composers\DashboardComposer');
        view()->composer('admin.section.top-nav','App\Http\View\Composers\NotificationComposer');
        view()->composer('admin.section.sidebar','App\Http\View\Composers\ClassAttendanceComposer');
        view()->composer('*', 'App\Http\View\Composers\SystemLang');
    }
}
