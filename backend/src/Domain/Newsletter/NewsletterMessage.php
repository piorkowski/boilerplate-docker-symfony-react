<?php

declare(strict_types=1);

namespace App\Domain\Newsletter;

class NewsletterMessage
{
    public function __construct(
        public string $id,
        public string $title,
        public string $message,
        public bool $active,
        public \DateTimeInterface $createdAt,
        public ?\DateTimeInterface $updatedAt,
    ) {
    }

    public function isActive(): bool
    {
        return true === $this->active;
    }

    public function activate(): void
    {
        $this->active = true;
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function deactivate(): void
    {
        $this->active = false;
        $this->updatedAt = new \DateTimeImmutable();
    }
}
