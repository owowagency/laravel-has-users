<?php

namespace OwowAgency\LaravelHasUsersWithRoles;

use Illuminate\Support\ServiceProvider;

class LaravelHasUsersWithRolesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/laravelhasuserswithroles.php';

        $this->mergeConfigFrom($configPath, 'laravelhasuserswithroles');

        $this->publishes([
            $configPath => config_path('laravelhasuserswithroles.php'),
        ], 'laravelhasuserswithroles');
    }
}
