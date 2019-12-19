<?php


namespace App\Services\Statistiques;

use Doctrine\ORM\EntityManagerInterface;

class Statistique
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getCountTotalUsers()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(u) FROM App\Entity\User u WHERE u.active = true'
        )->getSingleScalarResult();
    }

    public function getCountTotalJobs()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(j) FROM App\Entity\Job j'
        )->getSingleScalarResult();
    }

    public function getCountTotalCategories()
    {
        return $this->manager->createQuery(
            'SELECT COUNT (c) FROM App\Entity\Category c'
        )->getSingleScalarResult();
    }

    public function getCountTotalContact()
    {
        return $this->manager->createQuery(
            'SELECT COUNT (c) FROM App\Entity\Contact c'
        )->getSingleScalarResult();
    }

    public function getCountTotalApplies()
    {
        return $this->manager->createQuery(
            'SELECT COUNT(a) FROM App\Entity\Apply a'
        )->getSingleScalarResult();
    }
}