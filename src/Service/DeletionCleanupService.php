<?php

namespace App\Service;

use App\Entity\Company;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;

class DeletionCleanupService
{
    public function cleanupStudentDeletion(Student $student, EntityManagerInterface $entityManager): void
    {
        foreach ($student->getInternships()->toArray() as $internship) {
            $entityManager->remove($internship);
        }
    }

    public function cleanupCompanyDeletion(Company $company, EntityManagerInterface $entityManager): void
    {
        foreach ($company->getInternships()->toArray() as $internship) {
            $entityManager->remove($internship);
        }
    }
}
