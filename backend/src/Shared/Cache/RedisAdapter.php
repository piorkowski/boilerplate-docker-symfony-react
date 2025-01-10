<?php
declare(strict_types=1);


namespace App\Shared\Cache;


use Redis;

readonly class RedisAdapter implements CacheAdapterInterface
{
    public function __construct(
        private Redis $redis,
    )
    {
    }

public function get(CacheQueryInterface $cacheQuery): ?array
    {
        try {
        $cachedData = $this->redis->get($cacheQuery->getKey());

            if ($cachedData === null) {
                return null;
            }

            return json_decode($cachedData, false, 512, JSON_THROW_ON_ERROR);
        } catch (\Throwable $exception) {
            return null;
        }
    }

    public function set(CacheEntryInterface $cacheEntry): void
    {
        try {
            $this->redis->setex($cacheEntry->getKey(), $cacheEntry->getTTL(), $cacheEntry->getValue());
        } catch (\Throwable $exception) {
        }
    }

}
