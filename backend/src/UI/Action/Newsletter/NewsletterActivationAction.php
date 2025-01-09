<?php

declare(strict_types=1);

namespace App\UI\Action\Newsletter;

use App\Entity\NewsletterMember;
use App\Infrastructure\Repository\NewsletterMemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/newsletter/activation/{token}', name: 'newsletter_activation', methods: ['GET'])]
readonly class NewsletterActivationAction
{
    public function __construct(
        private NewsletterMemberRepository $newsletterMemberRepository,
        private MailerInterface $mailer,
    ) {
    }

    public function __invoke(
        string $token,
    ): JsonResponse {
        $newsletterMember = $this->newsletterMemberRepository->find($token);
        if ($newsletterMember instanceof NewsletterMember) {
            $newsletterMember->activate();
            $this->newsletterMemberRepository->saveMember($newsletterMember);
        }

        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($newsletterMember->getEmail())
            ->subject('Newsletter Activated')
            ->text('Your subscription has been activated.!')
            ->html('Your subscription has been activated.!')
        );

        return new JsonResponse(['newsletter activated' => true], Response::HTTP_OK);
    }
}