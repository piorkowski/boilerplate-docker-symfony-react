<?php

declare(strict_types=1);

namespace App\Shared\Command;

use App\Shared\Exception\CommandBusException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        #[Autowire(service: 'command.bus.default')]
        private MessageBusInterface $commandBus,
        private LoggerInterface $logger,
    ) {
    }

    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->logger->info('Dispatching command', [
                'class' => get_class($command),
                'payload' => method_exists($command, 'toArray') ? $command->toArray() : (array) $command,
            ]);

            $this->commandBus->dispatch($command);
        } catch (HandlerFailedException $exception) {
            $this->logException($exception);
            throw new CommandBusException($exception->getMessage(), previous: $exception->getPrevious());
        } catch (ExceptionInterface $exception) {
            $this->logException($exception);
            throw new CommandBusException($exception->getMessage(), previous: $exception->getPrevious());
        }
    }

    private function logException(\Throwable $exception): void
    {
        $this->logger->error('Exception during command dispatch', [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'stack_trace' => $exception->getTraceAsString(),
        ]);
    }
}
