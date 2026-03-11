<?php

namespace App\DataFixtures;

use App\Entity\ActionType;
use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\InternshipMilestone;
use App\Entity\Major;
use App\Entity\Milestone;
use App\Entity\MilestoneStatus;
use App\Entity\Role;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $savedRoles = [];
        foreach (['ROLE_ADMIN' => 'Administrateur', 'ROLE_TEACHER' => 'Enseignant', 'ROLE_SECRETARY' => 'Secrétariat'] as $code => $label) {
            $role = (new Role())->setCode($code)->setLabel($label);
            $manager->persist($role);
            $savedRoles[$code] = $role;
        }

        $savedMajors = [];
        foreach (['SLAM' => 'Solutions Logicielles et Applications Métier', 'SISR' => 'Solutions d\'Infrastructure, Systèmes et Réseaux'] as $code => $label) {
            $major = (new Major())->setCode($code)->setLabel($label);
            $manager->persist($major);
            $savedMajors[$code] = $major;
        }

        $savedMilestones = [];
        foreach (['THANK_YOU_LETTER' => 'Remerciement', 'REPORT' => 'Bilan / Suivi', 'JURY' => 'Jury', 'CERTIFICATE' => 'Attestation'] as $code => $label) {
            $ms = (new Milestone())->setCode($code)->setLabel($label);
            $manager->persist($ms);
            $savedMilestones[$code] = $ms;
        }

        $savedStatuses = [];
        foreach (['OK' => 'Validé', 'NOK' => 'Non validé', 'PENDING' => 'En attente'] as $code => $label) {
            $status = (new MilestoneStatus())->setCode($code)->setLabel($label);
            $manager->persist($status);
            $savedStatuses[$code] = $status;
        }

        $actionUpdate = (new ActionType())->setCode('STATUS_UPDATE')->setLabel('Mise à jour d\'un statut');
        $manager->persist($actionUpdate);

        $admin = (new User())->setEmail('admin@campus-la-chataigneraie.org')->setFirstName('Admin')->setLastName('Lycée');
        $admin->addUserRole($savedRoles['ROLE_ADMIN'])->setPassword($this->hasher->hashPassword($admin, 'pass_1234'));
        $manager->persist($admin);

        $secretary = (new User())->setEmail('secretaire@campus-la-chataigneraie.org')->setFirstName('Secrétaire')->setLastName('Lycée');
        $secretary->addUserRole($savedRoles['ROLE_SECRETARY'])->setPassword($this->hasher->hashPassword($secretary, 'pass_1234'));
        $manager->persist($secretary);

        $teachersList = [
            'Catherine Baranger', 'Réjane Boursier', 'Sandrine Ternisien', 'Nathalie Grandin', 'Marie Serrault',
            'Christophe Baudoux', 'Antoine Bloyet', 'Kévin Bayeul', 'Laurent Maurice', 'Robin Szylobryt'
        ];

        $savedTeachers = [];
        $slugger = new AsciiSlugger();

        foreach ($teachersList as $fullName) {
            [$firstName, $lastName] = explode(' ', $fullName);

            $cleanFirstName = strtolower((string) $slugger->slug($firstName));
            $cleanLastName = strtolower((string) $slugger->slug($lastName));

            $email = $cleanFirstName . '.' . $cleanLastName . '@campus-la-chataigneraie.org';

            $teacher = (new User())
                ->setEmail($email)
                ->setFirstName($firstName)
                ->setLastName($lastName);

            $teacher->addUserRole($savedRoles['ROLE_TEACHER'])
                    ->setPassword($this->hasher->hashPassword($teacher, 'pass_1234'));

            $manager->persist($teacher);
            $savedTeachers[] = $teacher;
        }

        $fakeCompanies = [];
        for ($i = 0; $i < 30; $i++) {
            $company = (new Company())
                ->setName($faker->company())
                ->setAddress($faker->streetAddress())
                ->setZipCode(substr(str_replace(' ', '', $faker->postcode()), 0, 5))
                ->setCity($faker->city())
                ->setContactName($faker->name())
                ->setPhone($faker->phoneNumber())
                ->setEmail($faker->companyEmail());

            $manager->persist($company);
            $fakeCompanies[] = $company;
        }

        $majorsList = array_values($savedMajors);
        $statusesList = array_values($savedStatuses);

        for ($i = 0; $i < 35; $i++) {
            $student = (new Student())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setPromotionYear(2026)
                ->setIsArchived($faker->boolean(5))
                ->setMajor($faker->randomElement($majorsList));
            $manager->persist($student);

            $startDate = $faker->dateTimeBetween('2026-01-01', '2026-02-01');
            $endDate = (clone $startDate)->modify('+6 weeks');

            $internship = (new Internship())
                ->setStudent($student)
                ->setCompany($faker->randomElement($fakeCompanies))
                ->setTrackingTeacher($faker->randomElement($savedTeachers))
                ->setVisitingTeacher($faker->randomElement($savedTeachers))
                ->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setRemarks($faker->optional(0.3)->realText(100));
            $manager->persist($internship);

            foreach ($savedMilestones as $milestone) {
                if ($faker->boolean(70)) {
                    $internshipMilestone = (new InternshipMilestone())
                        ->setInternship($internship)
                        ->setMilestone($milestone)
                        ->setStatus($faker->randomElement($statusesList))
                        ->setComment($faker->optional(0.2)->sentence());

                    if ($faker->boolean(50)) {
                        $valDate = $faker->dateTimeBetween($startDate->format('Y-m-d'), 'now');
                        $internshipMilestone->setValidatedAt($valDate);
                    }

                    $manager->persist($internshipMilestone);
                }
            }
        }

        $manager->flush();
    }
}
