<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Newsletter\NewsletterMessage;

interface NewsletterMessageRepositoryInterface
{
    public function saveMessage(NewsletterMessage $message): void;
}