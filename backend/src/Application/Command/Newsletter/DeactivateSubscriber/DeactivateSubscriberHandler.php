<?php
declare(strict_types=1);


namespace App\Application\Command\Newsletter\DeactivateSubscriber;


use App\Application\Repository\NewsletterMemberRepositoryInterface;
use App\Shared\Exception\CommandBusException;
use Psr\Log\LoggerInterface;

final readonly class DeactivateSubscriberHandler
{
    public function __construct(
        private NewsletterMemberRepositoryInterface $newsletterMemberRepository,
        private LoggerInterface $logger
    )
    {
    }

    public function __invoke(DeactivateSubscriberCommand $command): void
    {
        try{
            $member = $this->newsletterMemberRepository->getMember($command->memberId);
            $member->deactivate();
            $this->newsletterMemberRepository->saveMember($member);
            $this->logger->info('Member activated');
        } catch (\Throwable $exception) {
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
