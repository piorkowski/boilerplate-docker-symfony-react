<?php
declare(strict_types=1);

namespace App\Shared\Cache;

interface CacheAdapterInterface
{
    public function get(CacheQueryInterface $cacheQuery): ?array;

    public function set(CacheEntryInterface $cacheEntry): void;
}
