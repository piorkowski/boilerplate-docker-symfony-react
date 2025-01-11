<?php

declare(strict_types=1);

namespace App\Domain\Newsletter;

use App\Entity\DateTimeInterface;
use App\Infrastructure\Repository\NewsletterMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterMemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_MEMBER_EMAIL', fields: ['email'])]
class NewsletterMember
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        public string $id,
        #[ORM\Column(type: 'string')]
        public string $email,
        #[ORM\Column(type: 'string')]
        public string $name,
        #[ORM\Column(type: 'string', nullable: true)]
        public ?string $userId,
        #[ORM\Column(type: 'boolean')]
        public bool $active,
        #[ORM\Column(type: 'boolean')]
        public bool $acceptedTerms,
        #[ORM\Column(type: 'datetime_immutable')]
        public \DateTimeInterface $createdAt,
        #[ORM\Column(type: 'datetime_immutable', nullable: true)]
        public ?\DateTimeInterface $activatedAt,
    ) {
    }
    public function isAcceptedTerms(): bool
    {
        return true === $this->acceptedTerms;
    }

    public function activate(): void
    {
        $this->active = true;
        $this->activatedAt = new \DateTimeImmutable();
    }

    public function deactivate(): void
    {
        $this->active = false;
    }

    public function acceptTerms(): void
    {
        $this->acceptedTerms = true;
    }
}
