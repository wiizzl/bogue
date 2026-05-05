<?php

namespace App\Repository;

use App\Entity\Internship;
use App\Entity\User;
use App\Service\PaginationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Internship>
 */
class InternshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Internship::class);
    }

    /**
     * @return Internship[]
     */
    public function findForIndex(int $page = 1, int $limit = PaginationService::DEFAULT_ITEMS_PER_PAGE): array
    {
        $offset = max(0, ($page - 1) * $limit);

        return $this->createQueryBuilder('i')
            ->addSelect('s', 'c')
            ->innerJoin('i.student', 's')
            ->innerJoin('i.company', 'c')
            ->orderBy('s.lastName', 'ASC')
            ->addOrderBy('s.firstName', 'ASC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countForIndex(): int
    {
        return (int) $this->createQueryBuilder('i')
            ->select('COUNT(i.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param array $filters
     * @param User|null $user
     * @param int $page
     * @param int|null $limit
     * @return Paginator|array
     */
    public function findForTracking(array $filters, ?User $user = null, int $page = 1, ?int $limit = null): Paginator|array
    {
        $qb = $this->createQueryBuilder('i')
            ->addSelect('s', 'm', 'c', 'p')
            ->addSelect('tt', 'vt')
            ->distinct()

            ->innerJoin('i.student', 's')
            ->innerJoin('s.promotion', 'p')
            ->innerJoin('s.major', 'm')
            ->innerJoin('i.company', 'c')

            ->leftJoin('i.trackingTeacher', 'tt')
            ->leftJoin('i.visitingTeacher', 'vt')

            ->where('p.isArchived = false')

            ->orderBy('s.lastName', 'ASC')
            ->addOrderBy('s.firstName', 'ASC');

        $this->applyUserAccessFilter($qb, $user);
        $this->applySearchFilters($qb, $filters);

        if ($limit !== null) {
            $qb->setFirstResult(($page - 1) * $limit)
               ->setMaxResults($limit);

            return new Paginator($qb->getQuery(), true);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param User|null $user
     */
    private function applyUserAccessFilter($qb, ?User $user): void
    {
        if (!$user) {
            $qb->andWhere('1 = 0');
            return;
        }

        $userRoles = $user->getRoles();

        $isAdmin = in_array('ROLE_ADMIN', $userRoles);
        $isSecretary = in_array('ROLE_SECRETARY', $userRoles);
        $isTeacher = in_array('ROLE_TEACHER', $userRoles);

        if (!$isAdmin && !$isSecretary) {
            if (!$isTeacher) {
                $qb->andWhere('1 = 0');
                return;
            }

            $qb->andWhere(
                $qb->expr()->orX(
                    'i.trackingTeacher = :user',
                    'i.visitingTeacher = :user'
                )
            )
               ->setParameter('user', $user);
        }
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param array $filters
     */
    private function applySearchFilters($qb, array $filters): void
    {
        if (!empty($filters['major'])) {
            $qb->andWhere('m.id = :majorId')
               ->setParameter('majorId', $filters['major']);
        }

        if (!empty($filters['promotion'])) {
            $qb->andWhere('p.id = :promotionId')
               ->setParameter('promotionId', $filters['promotion']);
        }

        if (!empty($filters['teacher'])) {
            $qb->andWhere(
                $qb->expr()->orX(
                    'tt.id = :teacherId',
                    'vt.id = :teacherId'
                )
            )
               ->setParameter('teacherId', $filters['teacher']);
        }
    }

    /**
     * @param User $teacher
     * @return array
     */
    public function findByTeacher(User $teacher): array
    {
        $qb = $this->createQueryBuilder('i');
        $qb
            ->addSelect('s', 'm', 'c', 'p')
            ->innerJoin('i.student', 's')
            ->innerJoin('s.promotion', 'p')
            ->innerJoin('s.major', 'm')
            ->innerJoin('i.company', 'c')
            ->where('p.isArchived = false')
            ->andWhere($qb->expr()->orX('i.trackingTeacher = :teacher', 'i.visitingTeacher = :teacher'))
            ->setParameter('teacher', $teacher)
            ->orderBy('s.lastName', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
