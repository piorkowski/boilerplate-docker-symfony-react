<?php
declare(strict_types=1);


namespace App\Shared\Cache;


interface CacheEntryInterface
{
    public function getKey(): string;

    public function getValue(): string;

    public function getTTL(): int;
}
