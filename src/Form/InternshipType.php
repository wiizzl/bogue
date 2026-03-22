<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Internship;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
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
                'label' => 'Remarques',
                'required' => false,
                'attr' => ['rows' => 3]
            ])
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => static function (Student $student): string {
                    return $student->getFullName();
                },
                'label' => 'Étudiant',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->join('s.promotion', 'p')
                        ->where('p.isArchived = false')
                        ->orderBy('s.lastName', 'ASC');
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
            ->add('trackingTeacher', EntityType::class, $this->teacherFieldOptions('Suivi'))
            ->add('visitingTeacher', EntityType::class, $this->teacherFieldOptions('Visite'))
        ;
    }

    private function teacherFieldOptions(string $label): array
    {
        return [
            'class' => User::class,
            'label' => $label,
            'placeholder' => 'Choisir l\'enseignant...',
            'query_builder' => static function (UserRepository $er) {
                return $er->createQueryBuilder('u')
                    ->join('u.role', 'r')
                    ->where('r.code = :role')
                    ->setParameter('role', 'ROLE_TEACHER')
                    ->orderBy('u.lastName', 'ASC');
            },
            'choice_label' => static function (User $user): string {
                return $user->getFullName();
            },
        ];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Internship::class,
        ]);
    }
}
