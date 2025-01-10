<?php
declare(strict_types=1);


namespace App\Shared\Model;


use App\Shared\Event\DomainEventInterface;

class DomainEventModel
{
    /** @var DomainEventInterface[] */
    protected array $events = [];

    public function raise(DomainEventInterface $event): void
    {
        $this->events[] = $event;
    }

    /** @return DomainEventInterface[] */
    public function pullEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): void
    {
        $this->events = [];
    }
}
