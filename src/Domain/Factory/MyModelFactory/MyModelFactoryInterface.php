<?php

namespace App\Domain\Factory\MyModelFactory;

use App\Domain\Model\MyModelInterface;

/**
 * Interface MyModelFactoryInterface
 */
interface MyModelFactoryInterface
{
    /**
     * @param string $uuid
     * @return MyModelInterface
     */
    public function generate(string $uuid): MyModelInterface;
}
