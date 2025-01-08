<?php

declare(strict_types=1);

namespace App\UI\Action\Security;

use App\Entity\ActivationToken;
use App\Entity\User;
use App\UI\DTO\RegistrationUserData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

#[Route(path: '/registration', name: 'registration', methods: ['POST'])]
readonly class RegistrationAction
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] RegistrationUserData $registrationUserData,
    ): JsonResponse {
        $user = new User(
            id: Uuid::v4()->toString(),
            password: null,
            roles: ['ROLE_USER'],
            email: $registrationUserData->email,
        );

        $password = $this->userPasswordHasher->hashPassword($user, $registrationUserData->password);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $activationToken = new ActivationToken(
            id: Uuid::v4()->toString(),
            token: Uuid::v4()->toString(),
            userId: $user->getId(),
            expiresAt: new \DateTimeImmutable('now +2 hour'),
            used: false,
        );

        $this->entityManager->persist($activationToken);
        $this->entityManager->flush();

        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($user->getEmail())
            ->subject('Account registration')
            ->text('Your account has been created!')
            ->html(str_replace(
                search: '{link}',
                replace: $this->urlGenerator->generate('activation', ['token' => $activationToken->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),
                subject: 'Activate you account by clicking on the link below: <br/> <a href="{link}" target="_blank">{link}</a>',
            ))
        );

        return new JsonResponse(['registration' => true], Response::HTTP_OK);
    }
}
