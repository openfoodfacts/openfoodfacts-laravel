<?php

namespace OpenFoodFacts\Laravel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use OpenFoodFacts\Api;
use OpenFoodFacts\Document;
use OpenFoodFacts\Exception\ProductNotFoundException;

/** @mixin Api */
class OpenFoodFacts extends OpenFoodFactsApiWrapper
{
    protected int $max_results;

    public function __construct(Container $app, ?string $geography = null, string $environment = 'food')
    {
        parent::__construct(
            [
                'geography' => $geography ?? $app['config']->get('openfoodfacts.geography'),
                'app' => $app['config']->get('app.name'),
            ],
            $app['cache.store'],
            $environment
        );

        $this->max_results = $app['config']->get('openfoodfacts.max_results', 1000);
    }

    /**
     * Find product by barcode
     *
     * @param string $value
     * @return array
     */
    public function barcode(string $value): array
    {
        if (empty($value)) {
            throw new InvalidArgumentException('Argument must represent a barcode');
        }

        try {
            $doc = $this->api->getProduct($value);

            return empty($doc->code) ? [] : (array) reset($doc);
        } catch (ProductNotFoundException) {
            return [];
        }
    }

    /**
     * Search products by term
     *
     * @param string $searchterm
     * @return Collection<int, array>
     */
    public function find(string $searchterm): Collection
    {
        if (empty($searchterm)) {
            throw new InvalidArgumentException('Specify a search term to find data for matching products');
        }

        /** @var Collection<int, Document> $products */
        $products = Collection::make();
        $page = 0;

        do {
            $pageResults = $this->api->search($searchterm, ++$page, 100);
            $totalMatches = $pageResults->searchCount();

            if ($this->max_results > 0 && $totalMatches > $this->max_results) {
                throw new \Exception("ERROR: {$totalMatches} results found, while buffer limited to {$this->max_results}. Please narrow your search.");
            }

            $pages = (int)ceil($totalMatches / $pageResults->getPageSize());
            /** @var Document[] $array */
            $array = iterator_to_array($pageResults);

            $products = $products->concat($array);
        } while ($page < $pages);

        return $products->map(function ($product) {
            /**
             * @var array $value
             * Just to avoid error from phpstan :
             * > Method OpenFoodFacts\Laravel\OpenFoodFacts::find() should return Illuminate\Support\Collection<int, array> but returns Illuminate\Support\Collection<int, array{bool}>.
             */
            $value = (array) reset($product);

            return $value;
        });
    }

    public function __call(string $method, array $parameters): mixed
    {
        return $this->api->$method(...$parameters);
    }
}
