<?php

namespace App\Repository;

use App\Entity\Internship;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * Get filtered internships for tracking.
     */
    public function findForTracking(array $filters, ?User $user = null): array
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
            ->orderBy('s.lastName', 'ASC');

        if ($user && !in_array('ROLE_ADMIN', $user->getRoles())) {
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

        return $qb->getQuery()->getResult();
    }
}
