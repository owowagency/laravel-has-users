<?php

namespace OwowAgency\LaravelHasUsersWithRoles\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelHasUsersWithRoles\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    /**
     * Sets up the database.
     * 
     * @return void
     */
    private function setUpDatabase(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'laravel_has_users_with_roles.user_model_path',
            Support\Models\User::class
        );
    }
}
