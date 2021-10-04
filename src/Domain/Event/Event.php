<?php

namespace App\Domain\Event;

/**
 * Interface Event
 */
interface Event
{
    /**
     * @return string
     */
    public function getName(): string;
}
