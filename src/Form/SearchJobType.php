<?php

namespace App\Form;

use App\Entity\Category;
use App\Services\JobSearch\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchJobType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "Rechercher un emploi"
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'expanded' => true,
                'multiple' => true
            ])
            ->add('places', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'Etranger' => "Etranger",
                    'Belgique' => 'Belgique'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('contracts', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'Temps plein' => "Temps plein",
                    'Temps partiel' => 'Temps partiel'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('experiences', ChoiceType::class, [
                'required' => false,
                'label' => false,
                'choices' => [
                    'Avec expérience' => "Avec expérience",
                    'Sans expérience' => 'Sans expérience',
                    'Convention premier emploi' => 'Convention premier emploi'
                ],
                'multiple' => true,
                'expanded' => true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => "GET",
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}