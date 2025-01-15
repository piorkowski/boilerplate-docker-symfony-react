<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Repository\NewsletterMemberRepositoryInterface;
use App\Domain\Model\Newsletter\NewsletterMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterMember>
 */
class NewsletterMemberRepository extends ServiceEntityRepository implements NewsletterMemberRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterMember::class);
    }

    public function getMember(string $memberId): NewsletterMember
    {
        $newsletterMember = $this->find($memberId);
        if (!$newsletterMember instanceof NewsletterMember) {
            throw new EntityNotFoundException('Member not found');
        }

        return $newsletterMember;
    }

    public function saveMember(NewsletterMember $newsletterMember): void
    {
        $this->getEntityManager()->persist($newsletterMember);
        $this->getEntityManager()->flush();
    }
}
