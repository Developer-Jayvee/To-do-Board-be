<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contract\AuthProvider;
use App\Contract\TicketProvider;

use App\Services\AuthService;
use App\Services\TicketService;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        AuthProvider::class => AuthService::class,
        TicketProvider::class => TicketService::class
    ];

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
        //
    }
}
