<?php

namespace App\Repository;

use App\Entity\RegistrationToCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RegistrationToCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegistrationToCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegistrationToCourse[]    findAll()
 * @method RegistrationToCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegistrationToCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistrationToCourse::class);
    }

    // /**
    //  * @return RegistrationToCourse[] Returns an array of RegistrationToCourse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RegistrationToCourse
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findByCurrentUser($student)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Student = :username')
            ->setParameter('username', $student)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByRegistredCourse($courseName): ?RegistrationToCourse
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.Course = :courseName')
            ->setParameter('courseName', $courseName)
            ->getQuery()
            ->getResult()

        ;
    }
}
