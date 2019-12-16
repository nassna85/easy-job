<?php

namespace App\Form;

use App\Entity\Apply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cvResume', FileType::class, [
                'label' => false,
                'required' => true,
                'help' => "Votre cv au format PDF",
                'attr' => [
                    'placeholder' => "Séléctionner votre CV"
                ]
            ])
            ->add('coverLetter', FileType::class, [
                'label' => false,
                'required' => true,
                'help' => "Votre lettre de motivation au format PDF",
                'attr' => [
                    'placeholder' => "Séléctionner votre lettre de motivation"
                ]
            ])
            ->add('phoneNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apply::class,
        ]);
    }
}
