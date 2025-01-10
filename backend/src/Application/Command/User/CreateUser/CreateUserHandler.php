<?php
declare(strict_types=1);


namespace App\Application\Command\User\CreateUser;


use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct()
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {

    }
}
