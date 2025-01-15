<?php
declare(strict_types=1);


namespace App\Domain\Event\User;


use App\Shared\Event\DomainEventInterface;

class UserCreatedEvent implements DomainEventInterface
{
    public function getEventName(): string
    {
     return 'user.created';
    }

}
