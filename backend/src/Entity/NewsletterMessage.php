<?php

declare(strict_types=1);

namespace App\Entity;

use App\Infrastructure\Repository\NewsletterMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterMessageRepository::class)]
class NewsletterMessage
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        private string $id,
        #[ORM\Column(type: 'string')]
        private string $title,
        #[ORM\Column(type: 'text')]
        private string $message,
        #[ORM\Column(type: 'boolean')]
        private bool $active,
        #[ORM\Column(type: 'datetime_immutable')]
        private \DateTimeInterface $createdAt,
        #[ORM\Column(type: 'datetime_immutable', nullable: true)]
        private ?DateTimeInterface $updatedAt,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function isActive(): bool
    {
        return $this->active;
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
