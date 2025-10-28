<?php

namespace App\Providers;

use App\Services\DgiiServices;
use App\Services\ProveedorService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DgiiServices::class);
        $this->app->bind(ProveedorService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
