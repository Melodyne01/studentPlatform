<?php

namespace App\Repository;

use App\Entity\UE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UE|null find($id, $lockMode = null, $lockVersion = null)
 * @method UE|null findOneBy(array $criteria, array $orderBy = null)
 * @method UE[]    findAll()
 * @method UE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UE::class);
    }

    // /**
    //  * @return UE[] Returns an array of UE objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UE
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllAsc()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.Name', 'ASC')
            ->getQuery()
            ->getResult()

        ;
    }
    
}
