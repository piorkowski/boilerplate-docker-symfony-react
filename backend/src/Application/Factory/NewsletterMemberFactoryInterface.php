<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Model\Newsletter\NewsletterMember;

interface NewsletterMemberFactoryInterface
{
    public function create(string $email, string $name, ?string $userId): NewsletterMember;
}
