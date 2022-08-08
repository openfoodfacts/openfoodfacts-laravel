<?php

namespace OpenFoodFacts\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array barcode(string $value)
 * @method static \Illuminate\Support\Collection find(string $searchterm)
 *
 * @see \OpenFoodFacts\Laravel\OpenFoodFacts
 */
class OpenFoodFacts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openfoodfacts';
    }
}
