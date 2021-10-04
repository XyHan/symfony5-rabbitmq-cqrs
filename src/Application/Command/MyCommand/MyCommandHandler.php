<?php

namespace App\Application\Command\MyCommand;

use App\Domain\Command\CommandHandler;
use App\Domain\Event\EventBus;
use App\Application\Event\MyEvent\MyEvent;
use Throwable;
use Psr\Log\LoggerInterface;

/**
 * Class MyCommandHandler
 */
final class MyCommandHandler implements CommandHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * MyCommandHandler constructor.
     *
     * @param LoggerInterface $logger
     * @param EventBus $eventBus
     */
    public function __construct(
        LoggerInterface $logger,
        EventBus $eventBus,
    )
    {
        $this->logger = $logger;
        $this->eventBus = $eventBus;
    }

    /**
     * @param MyCommand $command
     */
    public function __invoke(MyCommand $command): void
    {
        try {
            $this->eventBus->dispatch(new MyEvent($command->getUuid()));
            $this->logger->info(sprintf('MyCommandHandler - Command with uuid %s has been handled', $command->getUuid()));
        } catch (Throwable $exception) {
            $message =  sprintf('MyCommandHandler - error. Previous: %s', $exception->getMessage());
            $this->logger->error($message);
            throw new MyCommandHandlerException($message);
        }
    }
}
