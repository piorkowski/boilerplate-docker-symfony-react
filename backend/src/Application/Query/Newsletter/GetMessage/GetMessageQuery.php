<?php

declare(strict_types=1);

namespace App\Application\Query\Newsletter\GetMessage;

use App\Shared\Query\QueryInterface;

final readonly class GetMessageQuery implements QueryInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
