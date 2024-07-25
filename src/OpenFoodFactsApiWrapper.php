<?php

namespace OpenFoodFacts\Laravel;

use GuzzleHttp\Client;
use OpenFoodFacts\Api;
use Psr\SimpleCache\CacheInterface;

class OpenFoodFactsApiWrapper
{
    public $api;

    public function __construct(
        protected array $parameters,
        protected ?CacheInterface $cache = null,
        string $environment = null
    ) {
        $this->api = $this->setupApi($environment);
    }

    protected function setupApi(string $environment = null): Api
    {
        return new Api(
            $environment ?? 'food',
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
