<?php

declare(strict_types=1);

namespace App\UI\DTO;

use App\UI\Validator\NameRequiredWhenNewsletterMember;
use Symfony\Component\Validator\Constraints as Assert;

#[NameRequiredWhenNewsletterMember]
final readonly class RegistrationUserData
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        public string $email,
        #[Assert\NotBlank]
        public string $password,
        public bool $newsletterMember = false,
        public ?string $name = null,
    ) {
    }
}
