<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\NewsletterMember;
use App\Entity\NewsletterMessage;

interface NewsletterMessageRepositoryInterface
{
    public function saveMessage(NewsletterMessage $message): void;
}
