<?php

declare(strict_types=1);

namespace App\Domain\Model\Newsletter;

class NewsletterMember
{
    public function __construct(
        public string $id,
        public string $email,
        public string $name,
        public ?string $userId,
        public bool $active,
        public bool $acceptedTerms,
        public \DateTimeInterface $createdAt,
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
