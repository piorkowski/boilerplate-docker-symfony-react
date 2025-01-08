<?php

declare(strict_types=1);

namespace App\UI\Action\Security;

use App\Entity\ActivationToken;
use App\Repository\ActivationTokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/activation/{token}', name: 'activation', methods: ['GET'])]
readonly class ActivationAction
{
    public function __construct(
        private ActivationTokenRepository $activationTokenRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(string $token): JsonResponse
    {
        /** @var ?ActivationToken $activationToken */
        $activationToken = $this->activationTokenRepository->findOneBy(['token' => $token]);
        if (null === $activationToken) {
            return new JsonResponse(['message' => 'Activation token not found'], 404);
        }

        if (false === $activationToken->canBeUsed()) {
            return new JsonResponse(['message' => 'Activation token cannot be used'], 403);
        }

        $user = $this->userRepository->find($activationToken->getUserId());
        if (null === $user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        if (true === $user->isActive()) {
            return new JsonResponse(['message' => 'User already active'], 403);
        }

        $user->activate();
        $activationToken->useToken();
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'User activated'], 200);
    }
}
