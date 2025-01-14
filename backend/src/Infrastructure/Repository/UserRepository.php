<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Exception\CannotActivateUserException;
use App\Application\Exception\CannotDeactivateUserException;
use App\Application\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface, UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUser(string $id): User
    {
        $user = $this->find($id);
        if (null === $user) {
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function saveUser(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function activateUser(string $userId): void
    {
        try {
            $user = $this->getUser($userId);
            $user->activate();
            $this->saveUser($user);
        } catch (\Throwable $e) {
            throw new CannotActivateUserException($e->getMessage(), previous: $e->getPrevious());
        }
    }

    public function deactivateUser(string $userId): void
    {
        try {
            $user = $this->getUser($userId);
            $user->deactivate();
            $this->saveUser($user);
        } catch (\Throwable $e) {
            throw new CannotDeactivateUserException($e->getMessage(), previous: $e->getPrevious());
        }
    }
}
