<?php

namespace App\DataFixtures;

use App\Entity\Major;
use App\Entity\Promotion;
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

        $currentYear = (int) (new \DateTimeImmutable())->format('Y');
        $existingPromotion = $manager->getRepository(Promotion::class)->findOneBy(['year' => $currentYear]);
        if (!$existingPromotion) {
            $manager->persist((new Promotion())->setYear($currentYear)->setIsArchived(false));
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
