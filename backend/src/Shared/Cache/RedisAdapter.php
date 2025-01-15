<?php

declare(strict_types=1);

namespace App\Shared\Cache;

use Psr\Log\LoggerInterface;

readonly class RedisAdapter implements CacheAdapterInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private \Redis $redis,
    ) {
    }


    public function get(CacheQueryInterface $cacheQuery): ?string
    {
        try {
            /** @var false|string $cachedData */
            $cachedData = $this->redis->get($cacheQuery->getKey());

            return $cachedData ?: null;
        } catch (\Exception $exception) {
            $this->logger->warning($exception->getMessage());
        }

        return null;
    }

    public function set(CacheEntryInterface $cacheEntry): void
    {
        try {
            $this->redis->set($cacheEntry->getKey(), $cacheEntry->getValue(), $cacheEntry->getTTL());
        } catch (\Exception $exception) {
            $this->logger->warning($exception->getMessage());
        }
    }
}
