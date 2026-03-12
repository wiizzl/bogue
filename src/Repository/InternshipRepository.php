<?php

namespace App\Repository;

use App\Entity\Internship;
use App\Entity\User;
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
     * Get filtered internships for tracking with pagination.
     */
    public function findForTracking(array $filters, ?User $user = null, int $page = 1, ?int $limit = null): Paginator|array
    {
        $qb = $this->createQueryBuilder('i')
            ->addSelect('s', 'm', 'c', 'tt', 'vt', 'im', 'mst')
            ->join('i.student', 's')
            ->join('s.major', 'm')
            ->join('i.company', 'c')
            ->leftJoin('i.trackingTeacher', 'tt')
            ->leftJoin('i.visitingTeacher', 'vt')
            ->leftJoin('i.milestones', 'im')
            ->leftJoin('im.status', 'mst')
            ->where('s.isArchived = false')
            ->orderBy('s.lastName', 'ASC');

        $isAdmin = $user && in_array('ROLE_ADMIN', $user->getRoles());
        $isSecretary = $user && in_array('ROLE_SECRETARY', $user->getRoles());

        if ($user && !$isAdmin && !$isSecretary) {
            $qb->andWhere('i.trackingTeacher = :user OR i.visitingTeacher = :user')
            ->setParameter('user', $user);
        }

        if (!empty($filters['major'])) {
            $qb->andWhere('m.id = :majorId')
               ->setParameter('majorId', $filters['major']);
        }

        if (!empty($filters['teacher'])) {
            $qb->andWhere('tt.id = :teacherId OR vt.id = :teacherId')
               ->setParameter('teacherId', $filters['teacher']);
        }

        if ($limit !== null) {
            $qb->setFirstResult(($page - 1) * $limit)
               ->setMaxResults($limit);

            return new Paginator($qb->getQuery());
        }

        return $qb->getQuery()->getResult();
    }
}
