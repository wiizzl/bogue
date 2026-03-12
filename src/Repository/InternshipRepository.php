<?php

namespace App\Repository;

use App\Entity\Internship;
use App\Entity\User;
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
            // Eager loading to prevent N+1 queries - only essential relations
            ->addSelect('s', 'm', 'c', 'p') // Student, Major, Company, Promotion
            ->addSelect('tt', 'vt')         // Teachers (may be null)
            // Use DISTINCT to handle potential duplicates from LEFT JOINs
            ->distinct()

            // Required joins for basic internship data
            ->innerJoin('i.student', 's')
            ->innerJoin('s.promotion', 'p')
            ->innerJoin('s.major', 'm')
            ->innerJoin('i.company', 'c')

            // Optional teacher assignments
            ->leftJoin('i.trackingTeacher', 'tt')
            ->leftJoin('i.visitingTeacher', 'vt')

            // Filter out archived promotions (business rule)
            ->where('p.isArchived = false')

            // Default ordering by student name for consistent results
            ->orderBy('s.lastName', 'ASC')
            ->addOrderBy('s.firstName', 'ASC');

        // Apply role-based access control
        $this->applyUserAccessFilter($qb, $user);

        // Apply optional filters
        $this->applySearchFilters($qb, $filters);

        // Handle pagination if limit specified
        if ($limit !== null) {
            $qb->setFirstResult(($page - 1) * $limit)
               ->setMaxResults($limit);

            return new Paginator($qb->getQuery(), true); // fetchJoinCollection = true for collections
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
            // No user = no access (should be handled by security but defensive coding)
            $qb->andWhere('1 = 0'); // Force empty result
            return;
        }

        $userRoles = $user->getRoles();

        // Admins and secretaries see everything
        $isAdmin = in_array('ROLE_ADMIN', $userRoles);
        $isSecretary = in_array('ROLE_SECRETARY', $userRoles);

        if (!$isAdmin && !$isSecretary) {
            // Teachers only see their assigned internships
            $qb->andWhere('i.trackingTeacher = :user OR i.visitingTeacher = :user')
               ->setParameter('user', $user);
        }
        // No additional filter for admin/secretary - they see all
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
        // Filter by major (student's specialization)
        if (!empty($filters['major'])) {
            $qb->andWhere('m.id = :majorId')
               ->setParameter('majorId', $filters['major']);
        }

        // Filter by teacher (either tracking or visiting)
        if (!empty($filters['teacher'])) {
            $qb->andWhere('tt.id = :teacherId OR vt.id = :teacherId')
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
        return $this->createQueryBuilder('i')
            ->addSelect('s', 'm', 'c', 'p')
            ->innerJoin('i.student', 's')
            ->innerJoin('s.promotion', 'p')
            ->innerJoin('s.major', 'm')
            ->innerJoin('i.company', 'c')
            ->where('p.isArchived = false')
            ->andWhere('i.trackingTeacher = :teacher OR i.visitingTeacher = :teacher')
            ->setParameter('teacher', $teacher)
            ->orderBy('s.lastName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
