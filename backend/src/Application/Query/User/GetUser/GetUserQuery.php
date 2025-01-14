<?php

declare(strict_types=1);

namespace App\Application\Query\User\GetUser;

use App\Shared\Query\QueryInterface;

final readonly class GetUserQuery implements QueryInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
