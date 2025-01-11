<?php
declare(strict_types=1);


namespace App\Application\Command\User\DeactivateUser;


use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class DeactivateUserHandler
{
    public function __construct()
    {
    }

    public function __invoke(DeactivateUserCommand $command): void
    {
        // TODO: Implement __invoke() method.
    }
}
