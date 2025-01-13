<?php
declare(strict_types=1);


namespace App\Domain\Factory;


use App\Application\Factory\UserFactoryInterface;
use App\Domain\User\User;

class UserFactory implements UserFactoryInterface
{
    public function create(string $email, string $password): User
    {
        // TODO: Implement create() method.
    }

}
