<?php

namespace App\Repository;

use App\Entity\TokenUserRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TokenUserRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenUserRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenUserRegistration[]    findAll()
 * @method TokenUserRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenUserRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenUserRegistration::class);
    }

    // /**
    //  * @return TokenUserRegistration[] Returns an array of TokenUserRegistration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TokenUserRegistration
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
