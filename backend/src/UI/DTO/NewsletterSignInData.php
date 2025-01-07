<?php
declare(strict_types=1);

namespace App\UI\DTO;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class NewsletterSignInData
{
    public function __construct(
        #[Assert\Email]
        #[Assert\NotBlank]
        public string $email,
        #[Assert\IsTrue()]
        public bool $acceptedTerm,
    )
    {
    }
}
