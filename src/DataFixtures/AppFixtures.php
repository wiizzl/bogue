<?php

namespace App\DataFixtures;

use App\Entity\ActionType;
use App\Entity\Major;
use App\Entity\Milestone;
use App\Entity\MilestoneStatus;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $savedRoles = [];
        foreach (['ROLE_ADMIN' => 'Administrateur', 'ROLE_TEACHER' => 'Enseignant', 'ROLE_SECRETARY' => 'Secrétariat'] as $code => $label) {
            $role = (new Role())->setCode($code)->setLabel($label);
            $manager->persist($role);
            $savedRoles[$code] = $role;
        }

        foreach (['SLAM' => 'Solutions Logicielles et Applications Métier', 'SISR' => 'Solutions d\'Infrastructure, Systèmes et Réseaux'] as $code => $label) {
            $major = (new Major())->setCode($code)->setLabel($label);
            $manager->persist($major);
        }

        foreach (['THANK_YOU_LETTER' => 'Remerciement', 'REPORT' => 'Bilan', 'JURY' => 'Jury', 'CERTIFICATE' => 'Attestation'] as $code => $label) {
            $ms = (new Milestone())->setCode($code)->setLabel($label);
            $manager->persist($ms);
        }

        foreach (['OK' => 'Validé', 'NOK' => 'Non validé', 'PENDING' => 'En attente'] as $code => $label) {
            $status = (new MilestoneStatus())->setCode($code)->setLabel($label);
            $manager->persist($status);
        }

        $actionTypes = [
            'STATUS_UPDATE' => 'Mise à jour d\'un statut',
            'TEACHER_UPDATE' => 'Mise à jour d\'un enseignant',
        ];
        $existingActionTypes = $manager->getRepository(ActionType::class)->findAll();
        $existingActionTypeCodes = [];
        foreach ($existingActionTypes as $existingActionType) {
            $existingActionTypeCodes[] = $existingActionType->getCode();
        }
        foreach ($actionTypes as $code => $label) {
            if (!in_array($code, $existingActionTypeCodes, true)) {
                $manager->persist((new ActionType())->setCode($code)->setLabel($label));
            }
        }

        $admin = (new User())->setEmail('admin@test.fr')->setFirstName('Admin')->setLastName('Test');
        $admin->addUserRole($savedRoles['ROLE_ADMIN'])->setPassword($this->hasher->hashPassword($admin, 'pass_1234'));
        $manager->persist($admin);

        $secretary = (new User())->setEmail('secretariat@test.fr')->setFirstName('Secrétariat')->setLastName('Test');
        $secretary->addUserRole($savedRoles['ROLE_SECRETARY'])->setPassword($this->hasher->hashPassword($secretary, 'pass_1234'));
        $manager->persist($secretary);

        $teacher = (new User())->setEmail('teacher@test.fr')->setFirstName('Enseignant')->setLastName('Test');
        $teacher->addUserRole($savedRoles['ROLE_TEACHER'])->setPassword($this->hasher->hashPassword($teacher, 'pass_1234'));
        $manager->persist($teacher);

        $manager->flush();
    }
}
