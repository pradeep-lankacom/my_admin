<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
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
        if (!class_exists('\Blade')) return;
        // Call to hasPermission
        \Blade::directive('permission', function($expression) {
            return "<?php if (\Auth::check() && \Auth::user()->hasPermission($expression)) { ?>";
        });
        \Blade::directive('endpermission', function($expression) {
            return "<?php } ?>";
        });

        // Call to hasAnyRoleWithPermission
        \Blade::directive('can', function($expression) {
            return "<?php if (\Auth::check() && \Auth::user()->hasAnyRoleWithPermission(\Auth::user()->roles,$expression)) { ?>";
        });
        \Blade::directive('endcan', function($expression) {
            return "<?php } ?>";
        });


    }
}
