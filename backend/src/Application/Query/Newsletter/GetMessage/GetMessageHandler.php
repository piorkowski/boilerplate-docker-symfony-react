<?php

declare(strict_types=1);

namespace App\Application\Query\Newsletter\GetMessage;

use App\Application\Repository\NewsletterMessageRepositoryInterface;
use App\Domain\Model\Newsletter\NewsletterMessage;
use App\Shared\Exception\QueryBusException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetMessageHandler
{
    public function __construct(
        private NewsletterMessageRepositoryInterface $messageRepository,
    ) {
    }

    public function __invoke(GetMessageQuery $query): NewsletterMessage
    {
        try {
            return $this->messageRepository->getNewsletterMessage($query->id);
        } catch (\Throwable $exception) {
            throw new QueryBusException($exception->getMessage(), previous: $exception->getPrevious());
        }
    }
}
