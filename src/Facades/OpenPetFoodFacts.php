<?php

namespace OpenFoodFacts\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array barcode(string $value)
 * @method static \Illuminate\Support\Collection<int, array> find(string $searchTerm)
 * @method static \OpenFoodFacts\Document getProduct(string $barcode)
 *
 * @see \OpenFoodFacts\Laravel\OpenFoodFacts
 */
class OpenPetFoodFacts extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'openpetfoodfacts';
    }
}
