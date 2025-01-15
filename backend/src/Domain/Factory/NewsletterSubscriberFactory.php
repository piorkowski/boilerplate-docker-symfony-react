<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Application\Factory\NewsletterMemberFactoryInterface;
use App\Domain\Model\Newsletter\NewsletterMember;
use Symfony\Component\Uid\Uuid;

class NewsletterSubscriberFactory implements NewsletterMemberFactoryInterface
{
    public function create(string $email, string $name, ?string $userId): NewsletterMember
    {
        return new NewsletterMember(
            id: Uuid::v4()->toString(),
            email: $email,
            name: $name,
            userId: $userId,
            active: false,
            acceptedTerms: true,
            createdAt: new \DateTimeImmutable(),
            activatedAt: null,
        );
    }
}
