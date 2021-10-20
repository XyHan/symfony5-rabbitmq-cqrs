<?php

namespace App\Domain\Repository;

/**
 * Interface MyModelQueryRepositoryInterface
 */
interface MyModelQueryRepositoryInterface
{
    /**
     * @return array
     */
    public function listAll(): array;
}
