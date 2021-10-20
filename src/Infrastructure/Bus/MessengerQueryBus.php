<?php

namespace App\Infrastructure\Bus;

use App\Application\Query\MyQuery\MyQuery;
use App\Domain\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class MessengerQueryBus
 */
final class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param MyQuery $query
     * @return mixed
     */
    public function handleQuery(MyQuery $query): mixed
    {
        return $this->handle($query);
    }
}
