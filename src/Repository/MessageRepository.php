<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByReceived($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :receiver')
            ->setParameter('receiver', $value)
            ->orderBy('m.sentAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBySender($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.sender = :sender')
            ->setParameter('sender', $value)
            ->orderBy('m.sentAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByReceivedByCurentUser($value, $user)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :receiver')
            ->andWhere('m.sender = :sender')            
            ->setParameter('sender', $value)
            ->setParameter('receiver', $user)
            ->orderBy('m.sentAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByCurentUser($value, $user)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :receiver AND m.sender = :sender OR m.receiver = :sender AND m.sender = :receiver')          
            ->setParameter('sender', $value)
            ->setParameter('receiver', $user)
            ->orderBy('m.sentAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
