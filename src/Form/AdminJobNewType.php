<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Job;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminJobNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Titre de l'emploi"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Description de l'emploi | Qualités requises..."
                ]
            ])
            ->add('enterprise', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de l'entreprise"
                ]
            ])
            ->add('place', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Belgique' => "Belgique",
                    "Etranger" => "Etranger"
                ],
                'placeholder' => "Lieu de travail"
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'required' => true,
                'placeholder' => "Catégorie de l'emploi"
            ])
            ->add('experience', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Avec expérience' => "Avec expérience",
                    'Sans expérience' => "Sans expérience",
                    'Convention premier emploi' => "Convention premier emploi"
                ],
                'placeholder' => "Expérience demandée"
            ])
            ->add('contract', ChoiceType::class, [
                'label' => false,
                'required' => true,
                'choices' => [
                    'Temps plein' => "Temps plein",
                    'Temps partiel' => "Temps partiel"
                ],
                'placeholder' => "Type de contrat"
            ])
            ->add('contactPerson', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Nom de la personne de contact"
                ]
            ])
            ->add('emailContact', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => "Email de la personne de contact"
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.type = :type')
                        ->setParameter('type', 'Employeur')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => "lastName",
                'label' => false,
                'required' => true,
                'placeholder' => "Séléctionner un employeur"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
