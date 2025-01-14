<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\NewsletterMessageRepositoryInterface;
use App\Domain\Newsletter\NewsletterMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
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

    public function getNewsletterMessage(string $id): NewsletterMessage
    {
        $message = $this->find($id);
        if (null === $message) {
            throw new EntityNotFoundException('Newsletter Message not found');
        }

        return $message;
    }

    public function saveMessage(NewsletterMessage $message): void
    {
        $this->getEntityManager()->persist($message);
        $this->getEntityManager()->flush();
    }
}
