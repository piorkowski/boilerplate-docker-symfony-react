<?php

declare(strict_types=1);

namespace App\Application\Command\Newsletter\AddSubscriber;

use App\Application\Exception\CannotCreateSubscriberException;
use App\Application\Factory\NewsletterMemberFactoryInterface;
use App\Application\Repository\NewsletterMemberRepositoryInterface;
use App\Domain\Newsletter\NewsletterMember;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsMessageHandler]
final readonly class AddSubscriberHandler
{
    public function __construct(
        private NewsletterMemberRepositoryInterface $newsletterMemberRepository,
        private NewsletterMemberFactoryInterface $newsletterMemberFactory,
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(AddSubscriberCommand $command): void
    {
        try {
            $member = $this->newsletterMemberFactory->create($command->email, $command->name, $command->userId);
            $this->newsletterMemberRepository->saveMember($member);
            $this->sendEmail($member);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
            throw new CannotCreateSubscriberException($exception->getMessage(), previous: $exception->getPrevious());
        }
    }

    private function sendEmail(NewsletterMember $newsletterMember): void
    {
        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($newsletterMember->email)
            ->subject('Newsletter Activation')
            ->text('Your account has been created!')
            ->html(str_replace(
                search: '{link}',
                replace: $this->urlGenerator->generate('newsletter_activation', ['token' => $newsletterMember->id], UrlGeneratorInterface::ABSOLUTE_URL),
                subject: 'Activate you subscription by clicking on the link below: <br/> <a href="{link}" target="_blank">{link}</a>',
            ))
        );
    }
}
