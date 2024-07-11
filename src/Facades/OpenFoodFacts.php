<?php

namespace OpenFoodFacts\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Collection;
use OpenFoodFacts\Document;

/**
 * @method static array barcode(string $value)
 * @method static Collection find(string $searchTerm)
 * @method static Document getProduct(string $barcode)
 *
 * @see \OpenFoodFacts\Laravel\OpenFoodFacts
 */
class OpenFoodFacts extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return 'openfoodfacts';
    }
}
