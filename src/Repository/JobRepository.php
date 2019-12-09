<?php

namespace App\Repository;

use App\Entity\Job;
use App\Services\JobSearch\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    /**
     * Récupère les emplois en lien avec une recherche
     * @param SearchData $search
     * @return Job[]
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this->createQueryBuilder('j');

            //->orderBy('j.createdAt', 'ASC');

        if(!empty($search->getCategories()))
        {
            $query = $query
                ->select('c', 'j')
                ->join('j.categories', 'c')
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->getCategories());
        }
        if(!empty($search->getQ()))
        {
            $query = $query
                ->andWhere('j.title LIKE :q')
                ->setParameter('q', "%{$search->getQ()}%");
        }
        if(!empty($search->getContracts()))
        {
            $query = $query
                ->andWhere('j.contract LIKE :co')
                ->setParameter('co', $search->getContracts());
        }
        if(!empty($search->getExperiences()))
        {
            $query = $query
                ->andWhere('j.experience LIKE :e')
                ->setParameter('e', $search->getExperiences());
        }
        if(!empty($search->getPlaces()))
        {
            $query = $query
                ->andWhere('j.place LIKE :pl')
                ->setParameter('pl', $search->getPlaces());
        }
        $query = $query
            ->orderBy('j.createdAt', 'ASC');

        return $query->getQuery()->getResult();
    }

    /**
     * @param int $limit
     * @return Job[]
     */
    public function lastJobs(int $limit): array
    {
        return $this-> createQueryBuilder('j')
            ->orderBy('j.createdAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
         ;
    }

    // /**
    //  * @return Job[] Returns an array of Job objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Job
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
