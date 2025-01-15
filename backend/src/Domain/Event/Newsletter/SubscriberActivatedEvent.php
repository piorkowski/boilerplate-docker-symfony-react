<?php
declare(strict_types=1);


namespace App\Domain\Event\Newsletter;


use App\Shared\Event\DomainEventInterface;

class SubscriberActivatedEvent implements DomainEventInterface
{
    public function getEventName(): string
    {
        return 'newsletter.subscriber.activated';
    }

}
