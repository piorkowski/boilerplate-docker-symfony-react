<?php
declare(strict_types=1);

namespace App\Shared\Query;

use App\Shared\Exception\QueryBusException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;

class QueryBus implements QueryBusInterface
{
    use HandleTrait;

    public function query(object $query): mixed
    {
        try {
            return $this->handle($query);
        } catch (HandlerFailedException $exception) {
            $previous = $exception->getPrevious() ?? $exception;

            throw new QueryBusException(
                message: $previous->getMessage(),
                code: $previous->getCode(),
                previous: $previous,
            );
        }
    }
}
