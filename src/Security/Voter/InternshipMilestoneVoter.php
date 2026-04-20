<?php

namespace App\Security\Voter;

use App\Entity\InternshipMilestone;
use App\Entity\Internship;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class InternshipMilestoneVoter extends Voter
{
    use ChecksAssignedTeacher;

    public const EDIT = 'EDIT_MILESTONE';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT]) && $subject instanceof InternshipMilestone;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        /** @var InternshipMilestone $milestone */
        $milestone = $subject;
        $internship = $milestone->getInternship();

        if ($this->security->isGranted('ROLE_SECRETARY')) {
            return false;
        }

        if ($this->security->isGranted('ROLE_TEACHER')) {
            return $this->isAssignedTeacher($user, $internship);
        }

        return false;
    }
}
