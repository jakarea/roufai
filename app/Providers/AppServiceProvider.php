<?php

namespace App\Providers;

use App\Models\EnrollmentRequest;
use App\Models\SiteSetting;
use App\Observers\EnrollmentRequestObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Register observers
        EnrollmentRequest::observe(EnrollmentRequestObserver::class);

        // Share siteSettings with all views
        View::composer('*', function ($view) {
            $view->with('siteSettings', SiteSetting::getSettings());
        });
    }
}
