<?php
declare(strict_types=1);


namespace App\Application\Command\Newsletter\AddSubscriber;


use App\Shared\Command\CommandInterface;

final readonly class AddSubscriberCommand implements CommandInterface
{
    public function __construct(
        public string $email,
        public string $name,
        public bool $acceptedTerm,
    )
    {
    }
}
