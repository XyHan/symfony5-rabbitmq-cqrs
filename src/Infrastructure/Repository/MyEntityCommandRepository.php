<?php

namespace App\Infrastructure\Repository\Education;

use App\Domain\Model\MyModelInterface;
use App\Domain\Repository\Education\MyModelCommandRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * Class MyEntityCommandRepository
 */
class MyEntityCommandRepository extends MyEntityRepository implements MyModelCommandRepositoryInterface
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
     * @param MyModelInterface $myModel
     * @return MyModelInterface
     */
    public function save(MyModelInterface $myModel): MyModelInterface
    {
        try {
            $this->_em->persist($myModel);
            $this->_em->flush();
            return $myModel;
        } catch (Exception $exception) {
            throw new MyEntityRepositoryException(sprintf(
                'MyEntityRepository - Error during myEntity with uuid %s save. Previous: %s',
                $myModel->getUuid(),
                $exception->getMessage()
            ));
        }
    }
}
