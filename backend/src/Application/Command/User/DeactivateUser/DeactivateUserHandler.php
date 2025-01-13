<?php
declare(strict_types=1);


namespace App\Application\Command\User\DeactivateUser;


use App\Application\Exception\CannotDeactivateUserException;
use App\Infrastructure\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final readonly class DeactivateUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private MailerInterface $mailer,
        private LoggerInterface $logger,
    )
    {
    }

    public function __invoke(DeactivateUserCommand $command): void
    {
        try {
            $user = $this->userRepository->getUser($command->id);
            $user->deactivate();
            $this->userRepository->saveUser($user);
            $this->mailer->send($this->prepareEmail($user->email));
        }catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
            throw new CannotDeactivateUserException($exception->getMessage(), previous: $exception->getPrevious());
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }

    private function prepareEmail(string $email): Email
    {
        return (new Email())
            ->from('no-reply@example.com')
            ->to($email)
            ->subject('Account deactivated')
            ->text('Your account has been deactivated.!')
            ->html('Your account has been deactivated.!')
            ;
    }
}
