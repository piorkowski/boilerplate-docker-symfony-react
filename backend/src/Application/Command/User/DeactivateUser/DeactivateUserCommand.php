<?php

declare(strict_types=1);

namespace App\Application\Command\User\DeactivateUser;

use App\Shared\Command\CommandInterface;

final readonly class DeactivateUserCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
