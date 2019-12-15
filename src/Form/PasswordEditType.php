<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Mot de passe actuel"
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Nouveau mot de passe"
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Confirmer votre nouveau mot de passe"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => [
                'Default',
                'registration'
            ]
        ]);
    }
}
