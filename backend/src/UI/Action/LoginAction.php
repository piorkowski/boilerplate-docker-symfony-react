<?php
declare(strict_types=1);

namespace App\UI\Action;

use App\Entity\User;
use App\UI\DTO\LoginUserData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path:'/login', name: 'login', methods: ['POST'])]
final class LoginAction
{
    public function __construct(

    )
    {
    }

    public function __invoke(
        #[CurrentUser] ?User $user,
        #[MapRequestPayload] LoginUserData $loginUserData,
    ): JsonResponse
    {
        $test = 0;

        return new JsonResponse(['login' => true]);
    }
}
