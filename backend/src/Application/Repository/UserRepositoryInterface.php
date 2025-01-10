<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\User\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserRepositoryInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;

    public function saveUser(User $user): void;
}