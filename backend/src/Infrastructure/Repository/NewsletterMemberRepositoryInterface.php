<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\NewsletterMember;

interface NewsletterMemberRepositoryInterface
{
    public function saveMember(NewsletterMember $newsletterMember): void;
}
