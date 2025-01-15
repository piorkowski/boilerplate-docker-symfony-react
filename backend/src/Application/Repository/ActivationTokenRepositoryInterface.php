<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\Model\User\ActivationToken;

interface ActivationTokenRepositoryInterface
{
    public function getActivationToken(string $token): ActivationToken;

    public function saveToken(ActivationToken $activationToken): void;
}
