<?php
declare(strict_types=1);


namespace App\Application\Command\User\ActivateUser;


use App\Shared\Command\CommandInterface;

final readonly class ActivateUserCommand implements CommandInterface
{
    public function __construct(
        public string $id,
    )
    {
    }
}
