<?php

namespace OpenFoodFacts\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array barcode(string $value)
 * @method static \Illuminate\Support\Collection find(string $searchTerm)
 * @method static \OpenFoodFacts\Document getProduct(string $barcode)
 *
 * @see \OpenFoodFacts\Laravel\OpenFoodFacts
 */
class OpenBeautyFacts extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'openbeautyfacts';
    }
}
