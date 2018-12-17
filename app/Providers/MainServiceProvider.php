<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
            'App\Repositories\Contracts\PermissionInterface',
            'App\Repositories\PermissionRepository'
        );



        $this->app->bind(
            'App\Repositories\Contracts\AdminUserInterface',
            'App\Repositories\AdminUserRepository'
        );


        $this->app->bind(
            'App\Repositories\Contracts\RoleInterface',
            'App\Repositories\RoleRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\DashboardInterface',
            'App\Repositories\DashboardRepository'
        );

    }
}
