<?php

namespace App\Service;

use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\HistoryLogRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeletionCleanupService
{
    public function __construct(private HistoryLogRepository $historyLogRepository)
    {
    }

    public function cleanupUserDeletion(User $user): void
    {
        foreach ($user->getTrackingInternships()->toArray() as $internship) {
            $internship->setTrackingTeacher(null);
        }

        foreach ($user->getVisitingInternships()->toArray() as $internship) {
            $internship->setVisitingTeacher(null);
        }

        $this->historyLogRepository->deleteByAuthor($user);
    }

    public function cleanupStudentDeletion(Student $student, EntityManagerInterface $entityManager): void
    {
        foreach ($student->getInternships()->toArray() as $internship) {
            $this->cleanupInternshipDeletion($internship, $entityManager);
            $entityManager->remove($internship);
        }
    }

    public function cleanupCompanyDeletion(Company $company, EntityManagerInterface $entityManager): void
    {
        foreach ($company->getInternships()->toArray() as $internship) {
            $this->cleanupInternshipDeletion($internship, $entityManager);
            $entityManager->remove($internship);
        }
    }

    public function cleanupInternshipDeletion(Internship $internship, EntityManagerInterface $entityManager): void
    {
        foreach ($internship->getHistoryLogs()->toArray() as $historyLog) {
            $historyLog->setInternship(null);
        }

        foreach ($internship->getMilestones()->toArray() as $milestone) {
            $entityManager->remove($milestone);
        }
    }
}
