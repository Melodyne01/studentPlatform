<?php

namespace App\Repository;

use App\Entity\WorkToSubmit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkToSubmit|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkToSubmit|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkToSubmit[]    findAll()
 * @method WorkToSubmit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkToSubmitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkToSubmit::class);
    }

    // /**
    //  * @return WorkToSubmit[] Returns an array of WorkToSubmit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkToSubmit
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
