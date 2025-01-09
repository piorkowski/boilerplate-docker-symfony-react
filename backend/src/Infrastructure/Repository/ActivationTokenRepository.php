<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\ActivationToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function saveToken(ActivationToken $activationToken): void
    {
        $this->getEntityManager()->persist($activationToken);
        $this->getEntityManager()->flush();
    }
}
