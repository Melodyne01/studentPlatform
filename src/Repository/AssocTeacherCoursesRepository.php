<?php

namespace App\Repository;

use App\Entity\AssocTeacherCourses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssocTeacherCourses|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssocTeacherCourses|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssocTeacherCourses[]    findAll()
 * @method AssocTeacherCourses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssocTeacherCoursesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssocTeacherCourses::class);
    }

    // /**
    //  * @return AssocTeacherCourses[] Returns an array of AssocTeacherCourses objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AssocTeacherCourses
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllAsc()
    {
        return $this->createQueryBuilder('n')
            ->orderBy('n.Teacher', 'ASC')
            ->getQuery()
            ->getResult()

        ;
    }
}
