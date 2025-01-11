<?php
declare(strict_types=1);


namespace App\Application\Command\Newsletter\DeactivateSubscriber;


use App\Shared\Command\CommandInterface;

final readonly class DeactivateSubscriberCommand implements CommandInterface
{
    public function __construct(
        public string $memberId,
    )
    {
    }
}
