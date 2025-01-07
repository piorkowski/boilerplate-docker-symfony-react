<?php
declare(strict_types=1);

namespace App\UI\Action;

use App\Entity\ActivationToken;
use App\Entity\NewsletterMember;
use App\Entity\User;
use App\UI\DTO\NewsletterSignInData;
use App\UI\DTO\RegistrationUserData;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

#[Route(path: '/newsletter/sign-in', name: 'newsletter_signin', methods: ['POST'])]
class SignInToNewsletterAction
{
    public function __construct(
        private readonly EntityManagerInterface      $entityManager,
        private readonly MailerInterface             $mailer,
        private readonly UrlGeneratorInterface $urlGenerator,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] NewsletterSignInData $newsletterSignInData,
    ): JsonResponse
    {
        $newsletterMember = new NewsletterMember(
            id: Uuid::v4()->toString(),
            email: $newsletterSignInData->email,
            userId: null,
            active: false,
            acceptedTerms: $newsletterSignInData->acceptedTerm,
            createdAt: new DateTimeImmutable(),
            activatedAt: null,
        );

        $this->entityManager->persist($newsletterMember);
        $this->entityManager->flush();


        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($newsletterMember->getEmail())
            ->subject('Newsletter Activation')
            ->text('Your account has been created!')
            ->html(str_replace(
                search: '{link}',
                replace: $this->urlGenerator->generate('newsletter_activation', ['token' => $newsletterMember->getId()], UrlGeneratorInterface::ABSOLUTE_URL),
                subject: 'Activate you subscription by clicking on the link below: <br/> <a href="{link}" target="_blank">{link}</a>',
                ))
        );

        return new JsonResponse(['newsletter ' => true], Response::HTTP_OK);
    }
}
