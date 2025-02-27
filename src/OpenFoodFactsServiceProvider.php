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

        // Bindings for each environment
        $this->app->singleton('openfoodfacts', fn (Container $app) => new OpenFoodFacts($app, environment: 'food'));
        $this->app->singleton('openbeautyfacts', fn (Container $app) => new OpenFoodFacts($app, environment: 'beauty'));
        $this->app->singleton('openpetfoodfacts', fn (Container $app) => new OpenFoodFacts($app, environment: 'pet'));
    }
}
