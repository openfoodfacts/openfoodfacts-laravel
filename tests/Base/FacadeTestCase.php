<?php

namespace OpenFoodFacts\Laravel\Tests\Base;

use Orchestra\Testbench\TestCase;
use OpenFoodFacts\Laravel\OpenFoodFactsServiceProvider;

abstract class FacadeTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [OpenFoodFactsServiceProvider::class];
    }
}
