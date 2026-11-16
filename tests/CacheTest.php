<?php

namespace OpenFoodFacts\Laravel\Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use OpenFoodFacts\Laravel\Cache\DefaultTtlCache;
use OpenFoodFacts\Laravel\OpenFoodFacts;
use PHPUnit\Framework\Attributes\Test;
use Psr\SimpleCache\CacheInterface;
use ReflectionProperty;

final class CacheTest extends Base\FacadeTestCase
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('cache.default', 'array');
    }

    #[Test]
    public function it_applies_the_default_ttl_when_none_is_given(): void
    {
        $cache = new DefaultTtlCache(Cache::store(), 60);

        $cache->set('key', 'value');
        $cache->setMultiple(['multi' => 'value']);

        $this->travel(59)->seconds();
        $this->assertTrue($cache->has('key'));
        $this->assertTrue($cache->has('multi'));

        $this->travel(2)->seconds();
        $this->assertFalse($cache->has('key'));
        $this->assertFalse($cache->has('multi'));
    }

    #[Test]
    public function it_keeps_an_explicitly_given_ttl(): void
    {
        $cache = new DefaultTtlCache(Cache::store(), 60);

        $cache->set('key', 'value', 3600);

        $this->travel(61)->seconds();
        $this->assertSame('value', $cache->get('key'));
    }

    #[Test]
    public function it_caches_forever_when_default_ttl_is_null(): void
    {
        $cache = new DefaultTtlCache(Cache::store(), null);

        $cache->set('key', 'value');

        $this->travel(10)->years();
        $this->assertSame('value', $cache->get('key'));
    }

    #[Test]
    public function api_responses_expire_after_the_configured_ttl(): void
    {
        Config::set('openfoodfacts.cache.ttl', '120');

        $cache = $this->apiCache(new OpenFoodFacts(app()));
        $this->assertInstanceOf(DefaultTtlCache::class, $cache);

        $cache->set('response', ['status' => 0, 'status_verbose' => 'product not found']);

        $this->travel(119)->seconds();
        $this->assertTrue($cache->has('response'));

        $this->travel(2)->seconds();
        $this->assertFalse($cache->has('response'));
    }

    #[Test]
    public function api_responses_are_not_cached_when_disabled(): void
    {
        Config::set('openfoodfacts.cache.enabled', false);

        $this->assertNull($this->apiCache(new OpenFoodFacts(app())));
    }

    #[Test]
    public function it_uses_the_configured_cache_store(): void
    {
        Config::set('cache.stores.off', ['driver' => 'array']);
        Config::set('openfoodfacts.cache.store', 'off');

        $cache = $this->apiCache(new OpenFoodFacts(app()));
        $this->assertInstanceOf(CacheInterface::class, $cache);
        $cache->set('key', 'value');

        $this->assertSame('value', Cache::store('off')->get('key'));
        $this->assertFalse(Cache::store()->has('key'));
    }

    private function apiCache(OpenFoodFacts $instance): ?CacheInterface
    {
        $cache = (new ReflectionProperty($instance->api, 'cache'))->getValue($instance->api);
        $this->assertTrue($cache === null || $cache instanceof CacheInterface);

        return $cache;
    }
}
