<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserRepositoryInterface
{
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;

    public function saveUser(User $user): void;
}
