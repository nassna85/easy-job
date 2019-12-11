<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Job;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $categories = ["Administration et Comptabilité", "Construction", "Enseignement et Formation", "Horeca", "Immobilier", "Informatique", "Santé", "Sécurité", "Nettoyage", "Transport et Logistique"];
        $contracts = ["Temps plein", "Temps partiel"];
        $experiences = ["Avec expérience", "Sans expérience", "Convention premier emploi"];
        $places = ["Etranger", "Belgique"];
        $types = ["Employeur", "Demandeur d'emploi"];
        $cats = [];
        $users = [];

        for($i = 0; $i < 20; $i++)
        {
            $user = new User();
            $user->setFirstName($faker->firstName())
                 ->setLastName($faker->lastName())
                 ->setPassword($this->encoder->encodePassword($user, 'password'))
                 ->setEmail($faker->email())
                 ->setType($faker->randomElement($types));
            $manager->persist($user);
            $users[] = $user;
        }

        for($i = 0; $i < 10; $i++)
        {
            $category = new Category();
            $category->setName($categories[$i]);
            $manager->persist($category);
            $cats[] = $category;
        }

        for($i = 0; $i < 50; $i++)
        {
            $job = new Job();
            $job->setTitle($faker->sentence(4))
                ->setDescription($faker->paragraph(20))
                ->setContactPerson($faker->name())
                ->setContract($faker->randomElement($contracts))
                ->setEmailContact($faker->email)
                ->setEnterprise($faker->sentence(3))
                ->setExperience($faker->randomElement($experiences))
                ->setPlace($faker->randomElement($places))
                ->setCategories($faker->randomElement($cats))
                ->setAuthor($faker->randomElement($users));
            $manager->persist($job);
        }

        $manager->flush();
    }
}
