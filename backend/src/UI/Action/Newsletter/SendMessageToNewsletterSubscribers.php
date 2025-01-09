<?php

declare(strict_types=1);

namespace App\UI\Action\Newsletter;

use App\Infrastructure\Repository\NewsletterMemberRepository;
use App\Infrastructure\Repository\NewsletterMessageRepository;
use App\UI\DTO\SendMessageToSubscribersData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/newsletter/send-message-to-subscribers', name: 'newsletter_send_message_to_subscribers', methods: ['POST'])]
readonly class SendMessageToNewsletterSubscribers
{
    public function __construct(
        private NewsletterMemberRepository $newsletterMemberRepository,
        private NewsletterMessageRepository $newsletterMessageRepository,
        private MailerInterface $mailer,
    ) {
    }

    public function __invoke(#[MapRequestPayload] SendMessageToSubscribersData $data): JsonResponse
    {
        $message = $this->newsletterMessageRepository->findOneBy(['id' => $data->messageId, 'active' => true]);
        if (null === $message) {
            return new JsonResponse('Message not found', 404);
        }

        $subscribers = $this->newsletterMemberRepository->findBy(['activate' => true, 'acceptedTerms' => true]);
        foreach ($subscribers as $subscriber) {
            $this->mailer->send((new Email())
                ->from('no-reply@example.com')
                ->to($subscriber->getEmail())
                ->subject($message->getTitle())
                ->text($message->getMessage())
                ->html($message->getMessage())
            );
        }

        return new JsonResponse('');
    }
}
