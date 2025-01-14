<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\ActivationTokenRepositoryInterface;
use App\Domain\User\ActivationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActivationToken>
 */
class ActivationTokenRepository extends ServiceEntityRepository implements ActivationTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActivationToken::class);
    }

    public function getActivationToken(string $token): ActivationToken
    {
        $token = $this->findOneBy(['token' => $token]);
        if (null === $token) {
            throw new EntityNotFoundException('Activation token not found');
        }

        return $token;
    }

    public function saveToken(ActivationToken $activationToken): void
    {
        $this->getEntityManager()->persist($activationToken);
        $this->getEntityManager()->flush();
    }
}
