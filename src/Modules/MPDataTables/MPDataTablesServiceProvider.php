<?php

namespace Ombimo\MrPanel\Modules\MPDataTables;

use Illuminate\Support\ServiceProvider;

class MPDataTablesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        //route
        $this->loadRoutesFrom(__DIR__.'/routes.php');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
