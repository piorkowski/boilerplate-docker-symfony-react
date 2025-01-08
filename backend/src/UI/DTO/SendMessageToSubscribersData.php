<?php

declare(strict_types=1);

namespace App\UI\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SendMessageToSubscribersData
{
    public function __construct(
        #[Assert\NotBlank]
        public string $messageId,
    ) {
    }
}
