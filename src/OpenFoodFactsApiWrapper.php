<?php

namespace OpenFoodFacts\Laravel;

use GuzzleHttp\Client;
use OpenFoodFacts\Api;
use Psr\SimpleCache\CacheInterface;

class OpenFoodFactsApiWrapper
{
    protected $parameters;
    protected $cache;

    public $api;

    public function __construct(array $parameters, CacheInterface $cache = null)
    {
        $this->parameters = $parameters;
        $this->cache = $cache;

        $this->api = $this->setupApi();
    }

    protected function setupApi($environment = 'food')
    {
        return new Api(
            $environment,
            $this->parameters['geography'] ?? 'world',
            null,
            $this->httpClient(),
            $this->cache
        );
    }

    protected function httpClient()
    {
        return new Client([
            'headers' => ['User-Agent' => $this->parameters['app'] ?? 'Laravel Open Food Facts - https://github.com/openfoodfacts/openfoodfacts-laravel'],
        ]);
    }
}
