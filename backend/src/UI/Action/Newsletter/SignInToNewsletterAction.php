<?php

declare(strict_types=1);

namespace App\UI\Action\Newsletter;

use App\Application\Repository\NewsletterMemberRepositoryInterface;
use App\Domain\Model\Newsletter\NewsletterMember;
use App\UI\DTO\NewsletterSignInData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

#[Route(path: '/newsletter/sign-in', name: 'newsletter_signin', methods: ['POST'])]
class SignInToNewsletterAction
{
    public function __construct(
        private readonly NewsletterMemberRepositoryInterface $newsletterMemberRepository,
        private readonly MailerInterface $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] NewsletterSignInData $newsletterSignInData,
    ): JsonResponse {
        $newsletterMember = new NewsletterMember(
            id: Uuid::v4()->toString(),
            email: $newsletterSignInData->email,
            userId: null,
            active: false,
            acceptedTerms: $newsletterSignInData->acceptedTerm,
            createdAt: new \DateTimeImmutable(),
            activatedAt: null,
        );

        $this->newsletterMemberRepository->saveMember($newsletterMember);

        return new JsonResponse(['newsletter ' => true], Response::HTTP_OK);
    }
}
