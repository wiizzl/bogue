<?php

namespace App\Security\Voter;

use App\Entity\Internship;
use App\Entity\User;

trait ChecksAssignedTeacher
{
    private function isAssignedTeacher(User $user, Internship $internship): bool
    {
        $userId = $user->getId();
        $trackingTeacherId = $internship->getTrackingTeacher()?->getId();
        $visitingTeacherId = $internship->getVisitingTeacher()?->getId();

        return $userId !== null && ($userId === $trackingTeacherId || $userId === $visitingTeacherId);
    }
}
