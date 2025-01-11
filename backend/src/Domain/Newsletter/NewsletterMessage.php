<?php

declare(strict_types=1);

namespace App\Domain\Newsletter;

use App\Infrastructure\Repository\NewsletterMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterMessageRepository::class)]
class NewsletterMessage
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        public string $id,
        #[ORM\Column(type: 'string')]
        public string $title,
        #[ORM\Column(type: 'text')]
        public string $message,
        #[ORM\Column(type: 'boolean')]
        public bool $active,
        #[ORM\Column(type: 'datetime_immutable')]
        public \DateTimeInterface $createdAt,
        #[ORM\Column(type: 'datetime_immutable', nullable: true)]
        public ?\DateTimeInterface $updatedAt,
    ) {
    }

    public function isActive(): bool
    {
        return true === $this->active ;
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
