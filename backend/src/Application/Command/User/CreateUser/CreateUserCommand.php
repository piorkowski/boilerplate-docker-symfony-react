<?php
declare(strict_types=1);


namespace App\Application\Command\User\CreateUser;


use App\Shared\Command\CommandInterface;

final readonly class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $password,
        public bool $newsletterSubscriber
    )
    {
    }
}
