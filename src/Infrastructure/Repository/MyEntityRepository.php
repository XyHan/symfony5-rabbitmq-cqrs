<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\MyEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MyEntityRepository
 */
class MyEntityRepository extends ServiceEntityRepository
{
    /**
     * MyEntityRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyEntity::class);
    }
}
