<?php
declare(strict_types=1);


namespace App\Application\Factory;


use App\Domain\User\User;

interface UserFactoryInterface
{
    public function create(string $email, string $password): User;
}
