<?php
declare(strict_types=1);


namespace App\Application\Command\User\CreateUser;


use App\Application\Factory\UserFactoryInterface;
use App\Infrastructure\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepository  $userRepository,
        private UserFactoryInterface $userFactory,
        private MailerInterface $mailer,
        private LoggerInterface $logger,
    )
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['email' => $command->email]);
        if(null !== $user) {
            throw new \DomainException('User already exists.');
        }

        $user = $this->userFactory->create($command->email, $command->password);
    }
}
