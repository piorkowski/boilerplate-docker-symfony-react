<?php
declare(strict_types=1);


namespace App\Application\Command\Newsletter\ActivateSubscriber;


use App\Application\Repository\NewsletterMemberRepositoryInterface;
use App\Domain\Newsletter\NewsletterMember;
use App\Shared\Exception\CommandBusException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final readonly class ActivateSubscriberHandler
{
    public function __construct(
        private NewsletterMemberRepositoryInterface $newsletterMemberRepository,
        private LoggerInterface $logger,
        private MailerInterface $mailer,
    )
    {
    }

    public function __invoke(ActivateSubscriberCommand $command): void
    {
        try{
            $member = $this->newsletterMemberRepository->getMember($command->memberId);
            $member->activate();
            $this->newsletterMemberRepository->saveMember($member);
            $this->logger->info('Member activated');
            $this->sendEmail($member);
        } catch (\Throwable $exception) {
            $this->logException($exception);
            throw new CommandBusException($exception->getMessage(), previous: $exception->getPrevious());
        }
    }

    private function logException(\Throwable $exception): void
    {
        $this->logger->error('Exception during command dispatch', [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'stack_trace' => $exception->getTraceAsString(),
        ]);
    }

    private function sendEmail(NewsletterMember $newsletterMember):void
    {
        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($newsletterMember->email)
            ->subject('Newsletter Activated')
            ->text('Your subscription has been activated!')
            ->html('Your subscription has been activated!')
        );
    }
}
