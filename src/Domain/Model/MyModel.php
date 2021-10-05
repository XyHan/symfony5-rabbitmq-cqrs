<?php

namespace App\Domain\Model;

/**
 * Class MyModel
 */
class MyModel implements MyModelInterface
{
    /**
     * @var string
     */
    protected string $uuid;

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return MyModel
     */
    public function setUuid(string $uuid): MyModel
    {
        $this->uuid = $uuid;
        return $this;
    }
}
