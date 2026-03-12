<?php

namespace App\Security\Voter;

use App\Entity\Internship;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class InternshipVoter extends Voter
{
    public const VIEW = 'VIEW_INTERNSHIP';
    public const EDIT = 'EDIT_INTERNSHIP';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT]) && $subject instanceof Internship;
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

        /** @var Internship $internship */
        $internship = $subject;

        switch ($attribute) {
            case self::VIEW:
                if ($this->security->isGranted('ROLE_SECRETARY')) {
                    return true;
                }

                return $user === $internship->getTrackingTeacher() || $user === $internship->getVisitingTeacher();

            case self::EDIT:
                if ($this->security->isGranted('ROLE_SECRETARY')) {
                    return false;
                }
                return $user === $internship->getTrackingTeacher() || $user === $internship->getVisitingTeacher();
        }

        return false;
    }
}
