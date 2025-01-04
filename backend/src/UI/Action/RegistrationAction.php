<?php
declare(strict_types=1);

namespace App\UI\Action;

use App\Entity\User;
use App\UI\DTO\RegistrationUserData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

#[Route(path:'/registration', name: 'registration', methods: ['POST'])]
class RegistrationAction
{
    public function __construct(
        private readonly UserPasswordHasherInterface $userPasswordHasher,
        private readonly EntityManagerInterface      $entityManager,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] RegistrationUserData $registrationUserData,
    ): JsonResponse
    {
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

        return new JsonResponse(['registration' => true], Response::HTTP_OK);
    }
}
