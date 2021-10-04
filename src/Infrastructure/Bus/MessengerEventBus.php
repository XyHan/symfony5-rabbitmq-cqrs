<?php

namespace App\Infrastructure\Bus;

use App\Domain\Event\Event;
use App\Domain\Event\EventBus;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerEventBus
 */
class MessengerEventBus implements EventBus
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $eventBus;

    /**
     * MessengerEventBus constructor
     *
     * @param MessageBusInterface $eventBus
     */
    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * @param Event $event
     */
    public function dispatch(Event $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
