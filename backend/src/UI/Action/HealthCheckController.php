<?php

declare(strict_types=1);

namespace App\UI\Action;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    #[Route('/healthcheck', name: 'healthcheck')]
    public function index(): Response
    {
        return new Response('OK', Response::HTTP_OK);
    }
}
