<?php

namespace App\Domain\Repository\Education;

use App\Domain\Model\MyModelInterface;

/**
 * Interface MyModelCommandRepositoryInterface
 */
interface MyModelCommandRepositoryInterface
{
    /**
     * @param MyModelInterface $myModel
     * @return MyModelInterface
     */
    public function save(MyModelInterface $myModel): MyModelInterface;
}
