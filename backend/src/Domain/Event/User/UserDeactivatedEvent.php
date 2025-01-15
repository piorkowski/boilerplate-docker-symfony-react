<?php
declare(strict_types=1);


namespace App\Domain\Event\User;


use App\Shared\Event\DomainEventInterface;

class UserDeactivatedEvent implements DomainEventInterface
{
    public function getEventName(): string
    {
     return 'user.deactivated';
    }

}
