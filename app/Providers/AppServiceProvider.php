<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot()
    {
        // Admin Gate - only admin role
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        });

        // Worker Gate - admin and site_worker roles
        Gate::define('access-worker', function ($user) {
            return in_array($user->role, ['admin', 'site_worker']);
        });

        // Inventory Clerk Gate - admin and inventory_clerk roles
        Gate::define('access-inventory-clerk', function ($user) {
            return in_array($user->role, ['admin', 'inventory_clerk']);
        });

        // Driver Gate - admin and driver roles
        Gate::define('access-driver', function ($user) {
            return in_array($user->role, ['admin', 'driver']);
        });

        // Optional: Additional specific gates for fine-grained control
        Gate::define('manage-users', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('manage-warehouses', function ($user) {
            return in_array($user->role, ['admin', 'inventory_clerk']);
        });

        Gate::define('manage-projects', function ($user) {
            return in_array($user->role, ['admin', 'site_worker']);
        });
    }
}
