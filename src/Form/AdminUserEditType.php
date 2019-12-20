<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserEditType extends AbstractType
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
                'required' => true,
                'label' => "Rôles de l'utilisateur",
                'choices' => [
                    'ROLE_USER' => "ROLE_USER",
                    'ROLE_ADMIN' => "ROLE_ADMIN"
                ],
                'placeholder' => "Séléctionner un ou plusieurs rôles",
                'expanded' => true,
                'multiple' => true
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'label' => "Type de l'utilisateur",
                'choices' => [
                    "Employeur" => "Employeur",
                    "Demandeur d'emploi" => "Demandeur d'emploi"
                ],
                'placeholder' => "Séléctionner le type d'utilisateur"
            ])
            ->add('active', CheckboxType::class, [
                'label' => "Activer l'utilisateur ?",
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => [
                'Default'
            ]
        ]);
    }
}
