<?php

namespace App\DataFixtures;

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
        $admin = new User();
        $admin->setEmail('admin@test.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname('John');
        $admin->setLastname('Doe');
        $admin->setPassword($this->hasher->hashPassword($admin, 'pass_1234'));
        $manager->persist($admin);

        $prof = new User();
        $prof->setEmail('prof@test.fr');
        $prof->setRoles(['ROLE_PROF']);
        $prof->setFirstname('Jane');
        $prof->setLastname('Smith');
        $prof->setPassword($this->hasher->hashPassword($prof, 'pass_1234'));
        $manager->persist($prof);

        $secretariat = new User();
        $secretariat->setEmail('secretariat@test.fr');
        $secretariat->setRoles(['ROLE_SECRETARIAT']);
        $secretariat->setFirstname('Emily');
        $secretariat->setLastname('Johnson');
        $secretariat->setPassword($this->hasher->hashPassword($secretariat, 'pass_1234'));
        $manager->persist($secretariat);

        $manager->flush();
    }
}
