<?php
declare(strict_types=1);

namespace App\UI\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final readonly class ExceptionResponseEventSubscriber
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof UnprocessableEntityHttpException) {
            $previous = $exception->getPrevious();

            if ($previous instanceof ValidationFailedException) {
                $violations = $previous->getViolations();
                $errors = [];

                foreach ($violations as $violation) {
                    $errors[] = [
                        'field' => $violation->getPropertyPath(),
                        'message' => $violation->getMessage(),
                    ];
                }

                $response = new JsonResponse(
                    [
                        'status' => 'error',
                        'message' => 'Validation failed.',
                        'errors' => $errors,
                    ],
                    JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );

                $event->setResponse($response);

                return;
            }
        }
    }
}
