<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\Repository\ActivationTokenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivationTokenRepository::class)]
#[ORM\Table(name: '`activation_token`')]
#[ORM\UniqueConstraint('UNIQUE_TOKEN', fields: ['token'])]
class ActivationToken
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        private readonly string $id,
        #[ORM\Column(type: 'string')]
        private readonly string $token,
        #[ORM\Column(nullable: true)]
        private readonly ?string $userId,
        #[ORM\Column(type: 'datetime')]
        private readonly \DateTimeInterface $expiresAt,
        #[ORM\Column(type: 'boolean')]
        private bool $used,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function useToken(): void
    {
        $this->used = true;
    }

    public function canBeUsed(): bool
    {
        return false === $this->isUsed() && false === $this->isExpired();
    }

    private function isExpired(): bool
    {
        return $this->expiresAt < new \DateTimeImmutable();
    }

    private function isUsed(): bool
    {
        return $this->used;
    }
}
