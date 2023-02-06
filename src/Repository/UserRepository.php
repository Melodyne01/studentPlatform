<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserPropertySearch;
use Doctrine\Migrations\Query\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * return Query
     */
    public function findAllAsc(UserPropertySearch $search)
    {
        $query = $this->createQueryBuilder('u');        

        if($search->getUsername()){
            $query = $query
            ->andWhere('u.username = :username')
            ->setParameter('username', $search->getUsername());
        }

        if($search->getClass() != 'NONE'){
            $query = $query
            ->andWhere('u.class = :class')
            ->setParameter('class', $search->getClass());  
        }
        if($search->getType() != 'NONE'){
            $query = $query
            ->andWhere('u.Type = :type')
            ->setParameter('type', $search->getType());  
        }
        $query = $query
        ->orderBy('u.username', 'ASC')
        ->getQuery()
        ->getResult();
        ;
        return $query;
    }
    public function findByCurrentUserAsc($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $username)
            ->orderBy('u.username', 'ASC')
            ->getQuery()
            ->getResult()

        ;
    }
    
}
