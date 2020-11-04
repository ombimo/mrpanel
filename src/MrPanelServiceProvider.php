<?php

namespace Ombimo\MrPanel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Ombimo\MrPanel\Commands\LinkAsset;
use Ombimo\MrPanel\Commands\PurgeTable;
use Illuminate\Support\Facades\Blade;

class MrPanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        //route
        include __DIR__ . '/routes.php';

        //view
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mrpanel');

        //migration
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        //middleware
        $router->aliasMiddleware('mrpanel.dashboard', 'Ombimo\MrPanel\Middleware\Dashboard');
        //dd($router->getMiddleware());


        //publish
        $this->publishes([
            __DIR__.'/../config/mrpanel.php' => config_path('mrpanel.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                PurgeTable::class,
                LinkAsset::class,
            ]);
        }

        Blade::directive('booleanIcon', function ($expression) {
            $true = '<i class="fas fa-check"></i>';
            $false = '<i class="fas fa-times"></i>';
            return "<?php echo {$expression} ? '$true' : '$false';?>";
        });

        //compose
        /*View::composer('mrpanel::_base.sidebar', function ($view) {
            $pages = App\Page::with('table')->orderBy('parent_id')->orderBy('position')->get();
            $view->with('menuPages', $pages);
        });*/

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->make('Ombimo\MrPanel\Controllers\AdminController');

        $this->app->register(Modules\MPDataTables\MPDataTablesServiceProvider::class);
    }
}
