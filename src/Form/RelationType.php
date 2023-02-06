<?php

namespace App\Form;

use App\Entity\UE;
use App\Entity\User;
use App\Entity\Courses;
use App\Repository\UERepository;
use App\Repository\UserRepository;
use App\Entity\AssocTeacherCourses;
use App\Repository\CoursesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('Course',EntityType::class, [
                'class' => Courses::class,
                'query_builder' => function (CoursesRepository $repo) {
                    return $repo->createQueryBuilder('c')
                    ->orderBy('c.Name', 'ASC');
                },

            ])
            ->add('Teacher',EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->andWhere('u.Type = :val')
                    ->setParameter('val', 'ROLE_TEACHER')
                    ->orderBy('u.username', 'ASC');
                },

            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AssocTeacherCourses::class,
            'csrf_protection' => false

        ]);
    }
}
