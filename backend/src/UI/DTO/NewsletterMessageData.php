<?php

declare(strict_types=1);

namespace App\UI\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class NewsletterMessageData
{
    public function __construct(
        #[Assert\NotBlank]
        public string $title,
        public string $message,
        public bool $active,
    ) {
    }
}
