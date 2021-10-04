<?php

namespace App\Application\Event\MyEvent;

use App\Domain\Event\Event;

/**
 * Class MyEvent
 */
class MyEvent implements Event
{
    /**
     * @var string
     */
    private string $uuid;

    /**
     * MyEvent constructor
     *
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return get_class($this);
    }
}
