<?php
declare(strict_types=1);


namespace App\Shared\Cache;


interface CacheQueryInterface
{
    public function getKey(): string;
}
