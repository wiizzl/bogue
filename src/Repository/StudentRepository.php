<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    private function createIndexQueryBuilder(bool $includeArchived = false)
    {
        $qb = $this->createQueryBuilder('s')
            ->innerJoin('s.promotion', 'p')
            ->innerJoin('s.major', 'm')
            ->addSelect('p', 'm')
            ->orderBy('s.lastName', 'ASC')
            ->addOrderBy('s.firstName', 'ASC');

        if (!$includeArchived) {
            $qb->andWhere('p.isArchived = :archived')
                ->setParameter('archived', false);
        }

        return $qb;
    }

    /**
     * @return Student[]
     */
    public function findForIndex(bool $includeArchived = false, int $page = 1, int $limit = 25): array
    {
        $offset = max(0, ($page - 1) * $limit);

        return $this->createIndexQueryBuilder($includeArchived)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countForIndex(bool $includeArchived = false): int
    {
        return (int) $this->createIndexQueryBuilder($includeArchived)
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
