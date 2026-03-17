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
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private KernelInterface $kernel;

    public function __construct(UserPasswordHasherInterface $hasher, KernelInterface $kernel)
    {
        $this->hasher = $hasher;
        $this->kernel = $kernel;
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

        foreach (['THANK_YOU' => 'Remerciement', 'REPORT' => 'Bilan', 'JURY' => 'Jury', 'CERTIFICATE' => 'Attestation'] as $code => $label) {
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
            'DATE_UPDATE' => 'Mise à jour des dates',
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

        if ('dev' === $this->kernel->getEnvironment()) {
            $devPassword = 'Bogue-Stage76!';

            $admin = (new User())->setEmail('admin@test.fr')->setFirstName('Administrateur')->setLastName('Bogue');
            $admin->setRole($savedRoles['ROLE_ADMIN'])->setPassword($this->hasher->hashPassword($admin, $devPassword));
            $manager->persist($admin);

            $secretary = (new User())->setEmail('secretary@test.fr')->setFirstName('Secrétaire')->setLastName('Bogue');
            $secretary->setRole($savedRoles['ROLE_SECRETARY'])->setPassword($this->hasher->hashPassword($secretary, $devPassword));
            $manager->persist($secretary);

            $teacher = (new User())->setEmail('teacher@test.fr')->setFirstName('Enseignant')->setLastName('Bogue');
            $teacher->setRole($savedRoles['ROLE_TEACHER'])->setPassword($this->hasher->hashPassword($teacher, $devPassword));
            $manager->persist($teacher);
        }

        $manager->flush();
    }
}
