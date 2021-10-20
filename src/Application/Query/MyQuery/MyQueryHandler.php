<?php

namespace App\Application\Query\MyQuery;

use App\Domain\Query\QueryHandler;
use App\Domain\Repository\MyModelQueryRepositoryInterface;
use Throwable;
use Psr\Log\LoggerInterface;

/**
 * Class MyQueryHandler
 */
final class MyQueryHandler implements QueryHandler
{
    /**
     * @var MyModelQueryRepositoryInterface
     */
    private MyModelQueryRepositoryInterface $myModelQueryRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * MyQueryHandler constructor.
     *
     * @param MyModelQueryRepositoryInterface $myModelQueryRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        MyModelQueryRepositoryInterface $myModelQueryRepository,
        LoggerInterface $logger,
    )
    {
        $this->myModelQueryRepository = $myModelQueryRepository;
        $this->logger = $logger;
    }

    /**
     * @param MyQuery $query
     * @return array
     */
    public function __invoke(MyQuery $query): array
    {
        try {
            return $this->myModelQueryRepository->listAll();
        } catch (Throwable $exception) {
            $message =  sprintf('MyQueryHandler - error. Previous: %s', $exception->getMessage());
            $this->logger->error($message);
            throw new MyQueryHandlerException($message);
        }
    }
}
