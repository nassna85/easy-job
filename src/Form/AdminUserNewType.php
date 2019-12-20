<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => "Prénom",
                'required' => true,
                'attr' => [
                    'placeholder' => "Prénom"
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => "Nom",
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom"
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Email",
                'required' => true,
                'attr' => [
                    'placeholder' => "Email"
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => "Rôle de l'utilisateur",
                'required' => false,
                'choices' => [
                    'ROLE_USER' => "ROLE_USER",
                    'ROLE_ADMIN' => "ROLE_ADMIN"
                ],
                'placeholder' => "Séléctionner le rôle",
                'expanded' => true,
                'multiple' => true
            ])
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe",
                'required' => true,
                'help' => "Entre 6 et 12 caractères",
                'attr' => [
                    'placeholder' => "Mot de passe"
                ]
            ])
            ->add('passwordConfirm', PasswordType::class, [
                'label' => "Confirmation du mot de passe",
                'required' => true,
                'attr' => [
                    'placeholder' => "Confirmation du mot de passe"
                ]
            ])
            ->add('type', ChoiceType::class, [
                'label' => "Type d'utilisateur",
                'required' => true,
                'choices' => [
                    'Employeur' => "Employeur",
                    "Demandeur d'emploi" => "Demandeur d'emploi"
                ],
                'placeholder' => "Séléctionnez un type d'utilisateur"
            ])
            ->add('active', CheckboxType::class, [
                'required' => false,
                'label' => "Activer l'utilisateur ?"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => [
                'Default',
                'registration'
            ]
        ]);
    }
}
