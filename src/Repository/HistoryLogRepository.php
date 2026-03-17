<?php

namespace App\Repository;

use App\Entity\HistoryLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryLog>
 */
class HistoryLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryLog::class);
    }

    public function findGlobalHistory(int $page = 1, int $limit = 20): Paginator
    {
        $allowedActionCodes = ['STATUS_UPDATE', 'TEACHER_UPDATE', 'DATE_UPDATE'];

        $qb = $this->createQueryBuilder('h')
            ->addSelect('at', 'au', 'i', 's')
            ->join('h.actionType', 'at')
            ->join('h.author', 'au')
            ->leftJoin('h.internship', 'i')
            ->leftJoin('i.student', 's')
            ->andWhere('at.code IN (:allowedActionCodes)')
            ->setParameter('allowedActionCodes', $allowedActionCodes)
            ->orderBy('h.createdAt', 'DESC');

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb);
    }
}
