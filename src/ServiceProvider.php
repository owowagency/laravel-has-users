<?php

namespace OwowAgency\LaravelHasUsersWithRoles;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/laravel_has_users_with_roles.php';

        $this->mergeConfigFrom($configPath, 'laravel_has_users_with_roles');

        $this->publishes([
            $configPath => config_path('laravel_has_users_with_roles.php'),
        ], 'laravel_has_users_with_roles');
    }
}
