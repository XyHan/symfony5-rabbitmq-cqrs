<?php

namespace App\Domain\Query;

use App\Application\Query\MyQuery\MyQuery;

/**
 * Interface QueryBus
 */
interface QueryBus
{
    /**
     * @param MyQuery $query
     */
    public function handleQuery(MyQuery $query): mixed;
}
