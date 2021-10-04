<?php

namespace App\Infrastructure\Bus;

use App\Domain\Command\Command;
use App\Domain\Command\CommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerCommandBus
 */
final class MessengerCommandBus implements CommandBus
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }
}
