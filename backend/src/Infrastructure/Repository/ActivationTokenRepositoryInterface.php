<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Entity\ActivationToken;

interface ActivationTokenRepositoryInterface
{
    public function saveToken(ActivationToken $activationToken): void;
}
