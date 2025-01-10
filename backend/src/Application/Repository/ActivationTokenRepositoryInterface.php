<?php

declare(strict_types=1);

namespace App\Application\Repository;

use App\Domain\User\ActivationToken;

interface ActivationTokenRepositoryInterface
{
    public function saveToken(ActivationToken $activationToken): void;
}
