<?php

declare(strict_types=1);

namespace App\Application\Query\User\GetUser;

use App\Application\Repository\UserRepositoryInterface;
use App\Domain\Model\User\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GetUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUserQuery $getUserQuery): User
    {
        return $this->userRepository->getUser($getUserQuery->id);
    }
}
