<?php

namespace App\Repository;

use App\Entity\MilestoneStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MilestoneStatus>
 */
class MilestoneStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilestoneStatus::class);
    }
}
