<?php

namespace OpenFoodFacts\Laravel;

use GuzzleHttp\Client;
use OpenFoodFacts\Api;
use Psr\SimpleCache\CacheInterface;

class OpenFoodFactsApiWrapper
{
    public readonly Api $api;

    public function __construct(
        public readonly array $parameters,
        protected readonly ?CacheInterface $cache = null
    ) {

        $this->api = $this->setupApi();
    }

    protected function setupApi(string $environment = 'food'): Api
    {
        return new Api(
            $environment,
            $this->parameters['geography'] ?? 'world',
            null,
            $this->httpClient(),
            $this->cache
        );
    }

    protected function httpClient(): Client
    {
        return new Client([
            'headers' => ['User-Agent' => $this->parameters['app'] ?? 'Laravel Open Food Facts - https://github.com/openfoodfacts/openfoodfacts-laravel'],
        ]);
    }
}
