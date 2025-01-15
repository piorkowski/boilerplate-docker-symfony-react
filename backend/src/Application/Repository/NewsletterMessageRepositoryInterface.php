<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Model\Newsletter\NewsletterMessage;

interface NewsletterMessageRepositoryInterface
{
    public function getNewsletterMessage(string $id): NewsletterMessage;

    public function saveMessage(NewsletterMessage $message): void;
}
