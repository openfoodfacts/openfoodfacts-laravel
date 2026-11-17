<?php

namespace OpenFoodFacts\Laravel\Cache;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

class DefaultTtlCache implements CacheInterface
{
    public function __construct(
        protected readonly CacheInterface $cache,
        protected readonly int|DateInterval|null $defaultTtl
    ) {
    }

    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->cache->get($key, $default);
    }

    public function set(mixed $key, mixed $value, mixed $ttl = null): bool
    {
        return $this->cache->set($key, $value, $ttl ?? $this->defaultTtl);
    }

    public function delete(mixed $key): bool
    {
        return $this->cache->delete($key);
    }

    public function clear(): bool
    {
        return $this->cache->clear();
    }

    public function getMultiple(mixed $keys, mixed $default = null): iterable
    {
        return $this->cache->getMultiple($keys, $default);
    }

    public function setMultiple(mixed $values, mixed $ttl = null): bool
    {
        return $this->cache->setMultiple($values, $ttl ?? $this->defaultTtl);
    }

    public function deleteMultiple(mixed $keys): bool
    {
        return $this->cache->deleteMultiple($keys);
    }

    public function has(mixed $key): bool
    {
        return $this->cache->has($key);
    }
}
