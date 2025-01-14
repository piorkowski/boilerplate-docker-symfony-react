<?php

declare(strict_types=1);

namespace App\UI\Action\Security;

use App\Application\Command\User\CreateUser\CreateUserCommand;
use App\Shared\Command\CommandBusInterface;
use App\UI\DTO\RegistrationUserData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/registration', name: 'registration', methods: ['POST'])]
readonly class RegistrationAction
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] RegistrationUserData $registrationUserData,
    ): JsonResponse {
        try {
            $this->commandBus->dispatch(new CreateUserCommand($registrationUserData->email, $registrationUserData->password, $registrationUserData->newsletterMember, $registrationUserData->name));

            return new JsonResponse(['registration' => true], Response::HTTP_OK);
        } catch (\Throwable $exception) {
            return new JsonResponse(['registration' => false, 'error_message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
