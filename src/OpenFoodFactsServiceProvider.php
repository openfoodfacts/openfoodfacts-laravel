<?php

namespace OpenFoodFacts\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class OpenFoodFactsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/openfoodfacts.php' => config_path('openfoodfacts.php'),
            ], 'config');
        }
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/openfoodfacts.php', 'openfoodfacts');

        // Binding for "beauty" environment
        $this->app->singleton('openfoodfacts', function (Container $app) {
            return new OpenFoodFacts($app);
        });

        // Binding for "beauty" environment
        $this->app->singleton('openbeautyfacts', function ($app) {
            return new OpenFoodFacts($app, environment:'beauty');
        });

        // Binding for "pet" environment
        $this->app->singleton('openpetfoodfacts', function ($app) {
            return new OpenFoodFacts($app, environment:'pet');
        });
    }
}
