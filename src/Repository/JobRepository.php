<?php

namespace App\Repository;

use App\Entity\Job;
use App\Services\JobSearch\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Job::class);
        $this->paginator = $paginator;
    }

    /**
     * Récupère les emplois en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this->createQueryBuilder('j');

            //->orderBy('j.createdAt', 'ASC');

        //ON UTILISE IN CAR C'EST UN TABLEAU DE REPONSE DONC ON UTILISE IN PUIS PARENTHèSE
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
                ->andWhere('j.contract IN (:co)')
                ->setParameter('co', $search->getContracts());
        }
        if(!empty($search->getExperiences()))
        {
            $query = $query
                ->andWhere('j.experience IN (:e)')
                ->setParameter('e', $search->getExperiences());
        }
        if(!empty($search->getPlaces()))
        {
            $query = $query
                ->andWhere('j.place IN (:pl)')
                ->setParameter('pl', $search->getPlaces());
        }
        $query = $query
            ->orderBy('j.createdAt', 'ASC');

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->getPage(),
            6
        );
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
