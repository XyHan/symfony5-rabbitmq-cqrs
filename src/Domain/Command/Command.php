<?php

namespace App\Domain\Command;

/**
 * Interface Command
 */
interface Command
{
    /**
     * @return string
     */
    public function getName(): string;
}
