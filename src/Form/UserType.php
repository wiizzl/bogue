<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email professionnelle',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'always_empty' => true,
                'required' => $options['action'] === 'new',
                'help' => $options['action'] === 'edit' ? 'Laissez vide pour conserver le mot de passe actuel' : 'Le mot de passe sera automatiquement haché en base de données'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('userRoles', EntityType::class, [
                'class' => Role::class,
                'label' => 'Rôles / Droits d\'accès',
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
                'help' => 'Un utilisateur peut cumuler plusieurs rôles'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'action' => 'new',
        ]);
    }
}
