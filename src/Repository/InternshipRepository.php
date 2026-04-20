<?php

namespace App\Repository;

use App\Entity\Internship;
use App\Entity\User;
use App\Service\PaginationService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository for Internship entities with optimized queries.
 *
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
     * Find filtered internships for tracking with optimized query and role-based access.
     *
     * This method builds an optimized query with proper eager loading to avoid N+1 problems.
     * It applies role-based filtering to ensure users only see internships they have access to.
     *
     * Performance optimizations:
     * - Uses DISTINCT to avoid duplicates from LEFT JOINs
     * - Selects only necessary fields to reduce memory usage
     * - Proper indexing expected on foreign keys (see migration)
     *
     * @param array $filters Array with 'major' and/or 'teacher' filter values
     * @param User|null $user Current authenticated user for access control
     * @param int $page Page number for pagination (1-based)
     * @param int|null $limit Results per page (null for no pagination)
     * @return Paginator|array Paginated results or array if no limit
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
     * Apply role-based access control filters to the query.
     *
     * Business rules:
     * - ADMIN: Full access to all internships
     * - SECRETARY: Full access to all internships
     * - TEACHER: Only assigned internships (tracking or visiting)
     * - Others: No access
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder to modify
     * @param User|null $user Current user
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
     * Apply search filters for major and teacher.
     *
     * Filters are validated and sanitized by the service layer before reaching here.
     *
     * @param \Doctrine\ORM\QueryBuilder $qb Query builder to modify
     * @param array $filters Validated filter array
     */
    private function applySearchFilters($qb, array $filters): void
    {
        if (!empty($filters['major'])) {
            $qb->andWhere('m.id = :majorId')
               ->setParameter('majorId', $filters['major']);
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
     * Find all active internships for a specific teacher.
     *
     * Returns internships where the teacher is assigned as tracking or visiting teacher.
     * Only includes internships from non-archived promotions.
     *
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
