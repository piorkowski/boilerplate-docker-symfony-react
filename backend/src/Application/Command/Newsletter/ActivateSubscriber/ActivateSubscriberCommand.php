<?php
declare(strict_types=1);


namespace App\Application\Command\Newsletter\ActivateSubscriber;


use App\Shared\Command\CommandInterface;

final readonly class ActivateSubscriberCommand implements CommandInterface
{
    public function __construct(
        public string $memberId,
    )
    {
    }
}
