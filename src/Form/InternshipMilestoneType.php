<?php

namespace App\Form;

use App\Entity\Internship;
use App\Entity\InternshipMilestone;
use App\Entity\Milestone;
use App\Entity\MilestoneStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InternshipMilestoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', EntityType::class, [
                'class' => MilestoneStatus::class,
                'choice_label' => 'label',
                'label' => 'Statut du document',
            ])
            ->add('validatedAt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de validation/réception',
                'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire / Remarque',
                'required' => false,
                'attr' => ['rows' => 3]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InternshipMilestone::class,
        ]);
    }
}
