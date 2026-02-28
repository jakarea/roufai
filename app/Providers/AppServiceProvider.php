<?php

namespace App\Providers;

use App\Models\EnrollmentRequest;
use App\Observers\EnrollmentRequestObserver;
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
        // Register observers
        EnrollmentRequest::observe(EnrollmentRequestObserver::class);
    }
}
