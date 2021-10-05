<?php

namespace App\Application\Command\MyCommand;

use App\Domain\Command\CommandHandler;
use App\Domain\Event\EventBus;
use App\Application\Event\MyEvent\MyEvent;
use App\Domain\Factory\MyModelFactory\MyModelFactoryInterface;
use App\Domain\Repository\MyModelCommandRepositoryInterface;
use Throwable;
use Psr\Log\LoggerInterface;

/**
 * Class MyCommandHandler
 */
final class MyCommandHandler implements CommandHandler
{
    /**
     * @var MyModelFactoryInterface
     */
    private MyModelFactoryInterface $myModelFactory;

    /**
     * @var MyModelCommandRepositoryInterface
     */
    private MyModelCommandRepositoryInterface $myModelCommandRepository;

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
     * @param MyModelFactoryInterface $myModelFactory
     * @param MyModelCommandRepositoryInterface $myModelCommandRepository
     * @param LoggerInterface $logger
     * @param EventBus $eventBus
     */
    public function __construct(
        MyModelFactoryInterface $myModelFactory,
        MyModelCommandRepositoryInterface $myModelCommandRepository,
        LoggerInterface $logger,
        EventBus $eventBus,
    )
    {
        $this->myModelFactory = $myModelFactory;
        $this->myModelCommandRepository = $myModelCommandRepository;
        $this->logger = $logger;
        $this->eventBus = $eventBus;
    }

    /**
     * @param MyCommand $command
     */
    public function __invoke(MyCommand $command): void
    {
        try {
            $myClass = $this->myModelFactory->generate($command->getUuid());
            $this->myModelCommandRepository->save($myClass);
            $this->eventBus->dispatch(new MyEvent($command->getUuid()));
            $this->logger->info(sprintf('MyCommandHandler - Command with uuid %s has been handled', $command->getUuid()));
        } catch (Throwable $exception) {
            $message =  sprintf('MyCommandHandler - error. Previous: %s', $exception->getMessage());
            $this->logger->error($message);
            throw new MyCommandHandlerException($message);
        }
    }
}
