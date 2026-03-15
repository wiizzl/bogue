<?php

namespace App\DataFixtures;

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

        if ('dev' === $this->kernel->getEnvironment()) {
            $admin = (new User())->setEmail('admin@test.fr')->setFirstName('Administrateur')->setLastName('Bogue');
            $admin->addUserRole($savedRoles['ROLE_ADMIN'])->setPassword($this->hasher->hashPassword($admin, 'pass_1234'));
            $manager->persist($admin);

            $secretary = (new User())->setEmail('secretary@test.fr')->setFirstName('Secrétaire')->setLastName('Bogue');
            $secretary->addUserRole($savedRoles['ROLE_SECRETARY'])->setPassword($this->hasher->hashPassword($secretary, 'pass_1234'));
            $manager->persist($secretary);

            $teacher = (new User())->setEmail('teacher@test.fr')->setFirstName('Enseignant')->setLastName('Bogue');
            $teacher->addUserRole($savedRoles['ROLE_TEACHER'])->setPassword($this->hasher->hashPassword($teacher, 'pass_1234'));
            $manager->persist($teacher);
        }

        $manager->flush();
    }
}
