<?php
declare(strict_types=1);

namespace App\UI\Action;

use App\UI\DTO\RegistrationUserData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path:'/registration', name: 'registration', methods: ['POST'])]
class RegistrationAction
{
    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function __invoke(
        #[MapRequestPayload] RegistrationUserData $registrationUserData,
    ): JsonResponse
    {
        return new JsonResponse(['registration' => true], Response::HTTP_OK);
    }
}
