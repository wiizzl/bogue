<?php

namespace App\Repository;

use App\Entity\HistoryLog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryLog>
 */
class HistoryLogRepository extends ServiceEntityRepository
{
    private const ALLOWED_ACTION_CODES = ['STATUS_UPDATE', 'TEACHER_UPDATE', 'DATE_UPDATE'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryLog::class);
    }

    private function createGlobalHistoryQueryBuilder()
    {
        return $this->createQueryBuilder('h')
            ->join('h.actionType', 'at')
            ->join('h.author', 'au')
            ->leftJoin('h.internship', 'i')
            ->leftJoin('i.student', 's')
            ->leftJoin('i.company', 'c')
            ->andWhere('at.code IN (:allowedActionCodes)')
            ->setParameter('allowedActionCodes', self::ALLOWED_ACTION_CODES);
    }

    public function countGlobalHistory(): int
    {
        return (int) $this->createGlobalHistoryQueryBuilder()
            ->select('COUNT(h.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findGlobalHistory(int $page = 1, int $limit = 20): Paginator
    {
        $qb = $this->createGlobalHistoryQueryBuilder()
            ->addSelect('at', 'au', 'i', 's', 'c')
            ->orderBy('h.createdAt', 'DESC');

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb);
    }

    public function countByAuthor(User $user): int
    {
        return (int) $this->createQueryBuilder('h')
            ->select('COUNT(h.id)')
            ->andWhere('h.author = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function deleteByAuthor(User $user): int
    {
        return $this->getEntityManager()
            ->createQuery('DELETE FROM App\\Entity\\HistoryLog h WHERE h.author = :user')
            ->setParameter('user', $user)
            ->execute();
    }
}
