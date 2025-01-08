<?php

declare(strict_types=1);

namespace App\UI\Action\Security;

use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/logout', name: 'logout', methods: ['GET'])]
class LogoutAction
{
    public function __invoke(): null
    {
        return null;
    }
}
