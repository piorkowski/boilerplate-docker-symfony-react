<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

class ActivationToken
{
    public function __construct(
        public readonly string $id,
        public readonly string $token,
        public readonly ?string $userId,
        public readonly \DateTimeInterface $expiresAt,
        public bool $used,
    ) {
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
