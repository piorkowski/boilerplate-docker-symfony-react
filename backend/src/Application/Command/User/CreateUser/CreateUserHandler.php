<?php

declare(strict_types=1);

namespace App\Application\Command\User\CreateUser;

use App\Application\Command\Newsletter\AddSubscriber\AddSubscriberCommand;
use App\Application\Exception\CannotCreateSubscriberException;
use App\Application\Factory\UserFactoryInterface;
use App\Application\Repository\ActivationTokenRepositoryInterface;
use App\Domain\Model\User\ActivationToken;
use App\Infrastructure\Repository\UserRepository;
use App\Shared\Command\CommandBusInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private ActivationTokenRepositoryInterface $activationTokenRepository,
        private UserFactoryInterface $userFactory,
        private MailerInterface $mailer,
        private LoggerInterface $logger,
        private UrlGeneratorInterface $urlGenerator,
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = $this->userRepository->findOneBy(['email' => $command->email]);
        if (null !== $user) {
            throw new \DomainException('User already exists.');
        }

        $user = $this->userFactory->createUser($command->email, $command->password);
        $this->userRepository->saveUser($user);
        $this->logger->info(sprintf('Created user "%s" with id - "%s".', $command->email, $user->id));

        $this->mailer->send($this->prepareEmail($user->email, $this->createActivationToken($user->id)));

        if (true === $command->newsletterSubscriber) {
            if (null === $command->name) {
                throw new CannotCreateSubscriberException('Subscriber name cannot be null.');
            }

            $this->commandBus->dispatch(new AddSubscriberCommand($user->email, $command->name, false, $user->id));
        }
    }

    private function prepareEmail(string $email, ActivationToken $activationToken): Email
    {
        return (new Email())
            ->from('no-reply@example.com')
            ->to($email)
            ->subject('Account registration')
            ->text('Your account has been created!')
            ->html(str_replace(
                search: '{link}',
                replace: $this->urlGenerator->generate('activation', ['token' => $activationToken->token], UrlGeneratorInterface::ABSOLUTE_URL),
                subject: 'Activate you account by clicking on the link below: <br/> <a href="{link}" target="_blank">{link}</a>',
            ));
    }

    private function createActivationToken(string $userId): ActivationToken
    {
        $activationToken = new ActivationToken(
            id: Uuid::v4()->toString(),
            token: Uuid::v4()->toString(),
            userId: $userId,
            expiresAt: new \DateTimeImmutable('now +2 hour'),
            used: false,
        );

        $this->activationTokenRepository->saveToken($activationToken);

        return $activationToken;
    }
}
