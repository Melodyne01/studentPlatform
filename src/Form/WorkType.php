<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Work;
use App\Entity\Courses;
use App\Repository\UserRepository;
use App\Entity\AssocTeacherCourses;
use App\Repository\CoursesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\AssocTeacherCoursesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class WorkType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('message')
            ->add('endDate', DateTimeType::class, [
                'date_label' => 'Ends On',
                ])
            
            ->add('addedBy', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->Where('u.username = :val')
                    ->setParameter('val', $this->security->getUser()->getUsername())
                    ->orderBy('u.username', 'ASC');
                }               
            ])
        ;
        if ($this->security->getUser()->getType() == 'ROLE_TEACHER'){
            $builder
                ->add('course', EntityType::class, [
                'class' => AssocTeacherCourses::class,
                'query_builder' => function (AssocTeacherCoursesRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->Where('u.Teacher = :val')
                    ->setParameter('val', $this->security->getUser()->getUsername())
                    ->orderBy('u.Course', 'ASC');
                },
                'choice_label' => 'Course',
                
            ]);
        }else{
            $builder
            ->add('course', EntityType::class, [
                'class' => Courses::class,
                'query_builder' => function (CoursesRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->orderBy('u.Name', 'ASC');
                },
                'choice_label' => 'Name',
                
            ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Work::class,
            'csrf_protection' => false,

        ]);
    }
}
