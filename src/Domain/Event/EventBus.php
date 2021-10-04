<?php

namespace App\Domain\Event;

/**
 * Interface EventBus
 */
interface EventBus
{
    /**
     * @param Event $event
     */
    public function dispatch(Event $event): void;
}
