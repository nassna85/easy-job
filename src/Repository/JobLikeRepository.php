<?php

namespace App\Repository;

use App\Entity\JobLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobLike[]    findAll()
 * @method JobLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobLike::class);
    }

    // /**
    //  * @return JobLike[] Returns an array of JobLike objects
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
    public function findOneBySomeField($value): ?JobLike
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
