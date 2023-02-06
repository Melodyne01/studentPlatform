<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Notes;
use App\Entity\ClassPropertySearch;
use App\Entity\NotesPropertySearch;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\RegistrationToCourseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Notes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notes[]    findAll()
 * @method Notes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notes::class);
    }

    // /**
    //  * @return Notes[] Returns an array of Notes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Notes
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/

    public function findByTeacher($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.addedBy = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findNotesBySearch(User $user, NotesPropertySearch $search)
    {
        $role = $user->getType();
        $username = $user->getUsername();
        
        //Création de la requête
        $query = $this->createQueryBuilder('n');
        //Filtre selon l'utilsateur authentifié
        if($role === 'ROLE_USER'){
            $query = $query->andWhere('n.User = :username');
        
        }else{
            $query = $query->andWhere('n.addedBy = :username');

        }
        $query = $query->setParameter('username', $username);

        //Applique le filtre concerant le course seulement si la case "apply" est cochée
        if($search->getCourse() && $search->getApply()){
            $query = $query
            ->andWhere('n.Course = :course')
            ->setParameter('course', $search->getCourse());
        }
        //Applique le filtre des notes si la valeur de "notes" est egale à "<10" ou ">10"
        //Le filtre ne s'applique pas si la valeur de "notes" est egale à "NONE"
        if($search->getNote() == '<10'){
            $query = $query
            ->andWhere('n.Note < 10');
        }else if($search->getNote() == '>10'){
            $query = $query
            ->andWhere('n.Note >= 10');
        }
        $query = $query
        ->orderBy('n.id', 'DESC')
        ->getQuery()
        ->getResult();
        ;
        return $query;
    }

    public function findBySearchClass(ClassPropertySearch $search)
    {       
        //Création de la requête
        $query = $this->createQueryBuilder('n');
        
        //Applique le filtre concerant le course seulement si la case "apply" est cochée
        if($search->getCourse()){
            $query = $query
            ->andWhere('n.Course = :course')
            ->setParameter('course', $search->getCourse());
        }
        if($search->getStudent()){
            $query = $query
            ->andWhere('n.User = :user')
            ->setParameter('user', $search->getStudent());
        }

        $query = $query
        ->orderBy('n.id', 'DESC')
        ->getQuery()
        ->getResult();
        ;
        return $query;
    }
        
}
