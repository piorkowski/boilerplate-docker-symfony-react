<?php

declare(strict_types=1);

namespace App\Application\Query\Newsletter\GetSubscribers;

use App\Shared\Query\QueryInterface;

class GetSubscribersQuery implements QueryInterface
{
    /**
     * @param array<string, mixed>|null                     $criteria
     * @param array<string, 'ASC'|'asc'|'DESC'|'desc'>|null $orderBy
     */
    public function __construct(
        public ?array $criteria,
        public ?array $orderBy,
    ) {
    }
}
