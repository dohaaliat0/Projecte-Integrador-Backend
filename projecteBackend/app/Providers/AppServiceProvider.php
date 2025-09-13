<?php

namespace App\Providers;

use App\Models\Zone;
use App\Policies\DarAltaPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\ZonePolicy;

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
        Gate::policy(User::class, DarAltaPolicy::class);
        Gate::policy(Zone::class,   ZonePolicy::class);
    }

}
