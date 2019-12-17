<?php

namespace App\Form;

use App\Entity\Apply;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

class ApplyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phoneNumber', TelType::class, [
                'label' => false,
                'required' => true,
                'help' => "0489/89/89/89",
                'attr' => [
                    'placeholder' => "Numéro de téléphone"
                ]
            ])
        ;
        $pdfFile = [
            new File([
                'maxSize' => '1000k',
                'mimeTypes' => [
                    'application/pdf',
                ],
                'mimeTypesMessage' => 'Veuillez insérer un fichier pdf valide !',
                'maxSizeMessage' => "La taille de votre fichier est trop grand ({{ size }} {{ suffix }}). Votre fichier doit faire maximum 1000kB !"
            ]),
            new NotNull([
                'message' => "Veuillez insérer un fichier pdf !"
            ])
        ];
        $builder
            ->add('cvResume', FileType::class, [
                'label' => false,
                'required' => true,
                'help' => "Votre cv au format PDF",
                'attr' => [
                    'placeholder' => "Séléctionner votre CV"
                ],
                'constraints' => $pdfFile
            ])
            ->add('coverLetter', FileType::class, [
                'label' => false,
                'required' => true,
                'help' => "Votre lettre de motivation au format PDF",
                'attr' => [
                    'placeholder' => "Séléctionner votre lettre de motivation"
                ],
                'constraints' => $pdfFile
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apply::class,
        ]);
    }
}
