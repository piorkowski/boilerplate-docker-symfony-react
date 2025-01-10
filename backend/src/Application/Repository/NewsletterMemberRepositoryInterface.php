<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Newsletter\NewsletterMember;

interface NewsletterMemberRepositoryInterface
{
    public function saveMember(NewsletterMember $newsletterMember): void;
}