<?php

namespace App\Domain\Command;

/**
 * Interface CommandBus
 */
interface CommandBus
{
    /**
     * @param Command $command
     */
    public function dispatch(Command $command): void;
}
