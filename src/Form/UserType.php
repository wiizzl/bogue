<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
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
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'always_empty' => true,
                'mapped' => false,
                'required' => $options['action'] === 'new',
            ]);

        if ($options['can_edit_roles']) {
            $builder->add('role', EntityType::class, [
                'class' => Role::class,
                'label' => 'Rôle',
                'choice_label' => 'label',
                'required' => true,
                'query_builder' => static function (RoleRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.code IN (:allowedRoles)')
                        ->setParameter('allowedRoles', ['ROLE_ADMIN', 'ROLE_SECRETARY', 'ROLE_TEACHER'])
                        ->orderBy('r.label', 'ASC');
                },
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'action' => 'new',
            'can_edit_roles' => false,
        ]);

        $resolver->setAllowedTypes('can_edit_roles', 'bool');
        $resolver->setAllowedValues('action', static fn (string $value): bool => in_array($value, ['new', 'edit'], true));
    }
}
