<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Application\Factory\UserFactoryInterface;
use App\Domain\Model\User\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

final readonly class UserFactory implements UserFactoryInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function createUser(string $email, string $password): User
    {
        $user = $this->initializeUser(
            email: $email,
            roles: ['ROLE_USER'],
        );

        $user->setPassword($this->hashPassword($user, $password));

        return $user;
    }

    public function createAdmin(string $email, string $password): User
    {
        $user = $this->initializeUser(
            email: $email,
            roles: ['ROLE_ADMIN', 'ROLE_USER'],
        );

        $user->setPassword($this->hashPassword($user, $password));

        return $user;
    }

    /**
     * Initialize a User instance with default values.
     *
     * @param list<string> $roles
     */
    private function initializeUser(string $email, array $roles): User
    {
        return new User(
            id: Uuid::v4()->toString(),
            password: null,
            roles: $roles,
            email: $email,
        );
    }

    private function hashPassword(User $user, string $password): string
    {
        return $this->userPasswordHasher->hashPassword($user, $password);
    }
}
