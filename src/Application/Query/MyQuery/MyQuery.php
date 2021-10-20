<?php

namespace App\Application\Query\MyQuery;

use App\Domain\Query\Query;

/**
 * Class MyQuery
 */
final class MyQuery implements Query
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return get_class($this);
    }
}
