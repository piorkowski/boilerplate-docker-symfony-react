<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Model\User\User;

interface UserFactoryInterface
{
    public function createUser(string $email, string $password): User;
}
