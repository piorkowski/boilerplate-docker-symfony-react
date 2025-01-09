<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\NewsletterMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterMessage>
 */
class NewsletterMessageRepository extends ServiceEntityRepository implements NewsletterMessageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterMessage::class);
    }

    public function saveMessage(NewsletterMessage $message): void
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }
}
