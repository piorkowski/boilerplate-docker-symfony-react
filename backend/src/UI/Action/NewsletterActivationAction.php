<?php
declare(strict_types=1);

namespace App\UI\Action;

use App\Entity\ActivationToken;
use App\Entity\NewsletterMember;
use App\Entity\User;
use App\Repository\NewsletterMemberRepository;
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
use Symfony\Component\Uid\Uuid;

#[Route(path: '/newsletter/activation/{token}', name: 'newsletter_activation', methods: ['GET'])]
class NewsletterActivationAction
{
    public function __construct(
        private readonly EntityManagerInterface              $entityManager,
        private readonly NewsletterMemberRepository $newsletterMemberRepository,
        private readonly MailerInterface            $mailer,
    )
    {
    }

    public function __invoke(
        string $token,
    ): JsonResponse
    {
        $newsletterMember = $this->newsletterMemberRepository->find($token);
        if ($newsletterMember instanceof NewsletterMember) {
            $newsletterMember->activate();
            $this->entityManager->persist($newsletterMember);
            $this->entityManager->flush();
        }


        $this->mailer->send((new Email())
            ->from('no-reply@example.com')
            ->to($newsletterMember->getEmail())
            ->subject('Newsletter Activated')
            ->text('Your subscription has been activated.!')
            ->html("Your subscription has been activated.!")
        );

        return new JsonResponse(['newsletter activated' => true], Response::HTTP_OK);
    }
}
