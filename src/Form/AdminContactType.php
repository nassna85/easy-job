<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminContactType extends AbstractType
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
            ->add('message', TextareaType::class, [
                'label' => "Message",
                'required' => true,
                'attr' => [
                    'placeholder' => "Message"
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => "Numéro de téléphone",
                'required' => false,
                'help' => "(0489/89/89/89)",
                'attr' => [
                    'placeholder' => "Numéro de téléphone"
                ]
            ])
            ->add('resolved', CheckboxType::class, [
                'required' => false,
                'label' => "La demande de contact est-elle résolue ?"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
