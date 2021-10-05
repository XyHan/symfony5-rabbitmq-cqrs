<?php

namespace App\Domain\Model;

/**
 * Interface MyModelInterface
 */
interface MyModelInterface
{
    /**
     * @return string
     */
    public function getUuid(): string;

    /**
     * @param string $uuid
     * @return MyModel
     */
    public function setUuid(string $uuid): MyModel;
}
