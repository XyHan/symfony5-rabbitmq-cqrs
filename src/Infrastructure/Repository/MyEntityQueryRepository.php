<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\MyModelInterface;
use App\Domain\Repository\MyModelQueryRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * Class MyEntityQueryRepository
 */
class MyEntityQueryRepository extends MyEntityRepository implements MyModelQueryRepositoryInterface
{
    /**
     * MyEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry);
    }

    /**
     * @return array
     */
    public function listAll(): array
    {
        try {
            return $this->findAll();
        } catch (Exception $exception) {
            throw new MyEntityRepositoryException(sprintf(
                'MyEntityQueryRepository - Error during list all myEntity. Previous: %s',
                $exception->getMessage()
            ));
        }
    }
}
