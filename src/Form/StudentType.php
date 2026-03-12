<?php

namespace App\Form;

use App\Entity\Major;
use App\Entity\Promotion;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('promotion', EntityType::class, [
                'class' => Promotion::class,
                'label' => 'Promotion',
                'choice_label' => 'year',
                'placeholder' => 'Choisir une promotion...',
                'label' => 'Année de promotion',
                'help' => 'Année de sortie prévue du BTS'
            ])
            ->add('major', EntityType::class, [
                'class' => Major::class,
                'label' => 'Filière spécialisée',
                'choice_label' => function (Major $major) {
                    return $major->getLabel() . '  (' . $major->getCode() . ')';
                },
                'placeholder' => 'Choisir une filière...',
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
