<?php

namespace App\Providers;

use App\Services\Contracts\TestServiceInterface;
use App\Services\MCPayService;
use App\Services\Test1Service;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TestServiceInterface::class, Test1Service::class);

        $this->app->singleton(MCPayService::class, function () {
            return new MCPayService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
