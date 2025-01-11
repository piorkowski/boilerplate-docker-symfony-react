<?php
declare(strict_types=1);


namespace App\Application\Command\User\ActivateUser;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ActivateUserHandler
{
    public function __construct(

    )
    {
    }

    public function __invoke(ActivateUserCommand $command): void
    {

    }
}
