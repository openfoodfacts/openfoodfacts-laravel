<?php

namespace OpenFoodFacts\Laravel\Tests\Base;

use OpenFoodFacts\Laravel\OpenFoodFactsServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class FacadeTestCase extends TestCase
{
    protected function getPackageProviders(\Illuminate\Foundation\Application $app): array
    {
        return [OpenFoodFactsServiceProvider::class];
    }
}
