<?php

namespace App\Form;

use App\Entity\Major;
use App\Entity\Promotion;
use App\Entity\Student;
use App\Repository\PromotionRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $student = $options['data'] instanceof Student ? $options['data'] : null;
        $currentPromotion = $student?->getPromotion();

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('promotion', EntityType::class, [
                'class' => Promotion::class,
                'choice_label' => 'year',
                'placeholder' => 'Choisir une promotion...',
                'label' => 'Année de promotion',
                'query_builder' => function (PromotionRepository $repository) use ($currentPromotion) {
                    $qb = $repository->createQueryBuilder('p')
                        ->orderBy('p.year', 'DESC');

                    if ($currentPromotion instanceof Promotion) {
                        $qb->where('p.isArchived = false OR p = :currentPromotion')
                            ->setParameter('currentPromotion', $currentPromotion);
                    } else {
                        $qb->where('p.isArchived = false');
                    }

                    return $qb;
                },
            ])
            ->add('major', EntityType::class, [
                'class' => Major::class,
                'label' => 'Option',
                'choice_label' => function (Major $major) {
                    return $major->getLabel() . '  (' . $major->getCode() . ')';
                },
                'placeholder' => 'Choisir une option...',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
