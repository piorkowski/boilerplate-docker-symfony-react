<?php
declare(strict_types=1);

namespace App\Shared\Event;

interface DomainEventDispatcherInterface
{
    public function dispatch(DomainEventInterface $event): void;
}
