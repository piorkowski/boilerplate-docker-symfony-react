<?php
declare(strict_types=1);

namespace App\Shared\Event\DomainEvent;

use App\Shared\Event\DomainEventDispatcherInterface;
use App\Shared\Event\DomainEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

readonly class DomainEventDispatcher implements DomainEventDispatcherInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function dispatch(DomainEventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
}
