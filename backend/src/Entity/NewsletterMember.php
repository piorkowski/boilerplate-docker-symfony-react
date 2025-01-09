<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\Repository\NewsletterMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterMemberRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_MEMBER_EMAIL', fields: ['email'])]
class NewsletterMember
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        private string $id,
        #[ORM\Column(type: 'string')]
        private string $email,
        #[ORM\Column(type: 'string', nullable: true)]
        private ?string $userId,
        #[ORM\Column(type: 'boolean')]
        private bool $active,
        #[ORM\Column(type: 'boolean')]
        private bool $acceptedTerms,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeInterface $createdAt,
        #[ORM\Column(type: 'datetime_immutable', nullable: true)]
        private ?DateTimeInterface $activatedAt,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isAcceptedTerms(): bool
    {
        return $this->acceptedTerms;
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
