<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Remarques / Commentaires',
                'required' => false,
                'attr' => ['rows' => 3]
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'label' => 'Étudiant',
                'placeholder' => 'Sélectionnez un étudiant...',
                'choice_label' => function (Student $student) {
                    return strtoupper($student->getLastName()) . ' ' . $student->getFirstName();
                },
            ])
            ->add('company', EntityType::class, [
                'class' => Company::class,
                'label' => 'Entreprise d\'accueil',
                'placeholder' => 'Sélectionnez une entreprise...',
                'choice_label' => function (Company $company) {
                    return $company->getName() . ' (' . $company->getCity() . ')';
                },
            ])
            ->add('trackingTeacher', EntityType::class, [
                'class' => User::class,
                'label' => 'Professeur de suivi',
                'placeholder' => 'Choisir l\'enseignant...',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.userRoles', 'r')
                        ->where('r.code = :role')
                        ->setParameter('role', 'ROLE_TEACHER')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
            ])
            ->add('visitingTeacher', EntityType::class, [
                'class' => User::class,
                'label' => 'Professeur de visite',
                'placeholder' => 'Choisir l\'enseignant...',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->join('u.userRoles', 'r')
                        ->where('r.code = :role')
                        ->setParameter('role', 'ROLE_TEACHER')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Internship::class,
        ]);
    }
}
