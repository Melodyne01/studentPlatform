<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Notes;
use App\Entity\Courses;
use App\Repository\UserRepository;
use App\Entity\AssocTeacherCourses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\AssocTeacherCoursesRepository;
use App\Repository\CoursesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
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
            
            ->add('User', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $userRepo) {
                    return $userRepo->createQueryBuilder('u')
                    ->Where('u.Type = :val')
                    ->setParameter('val', 'ROLE_USER')
                    ->orderBy('u.username', 'ASC');
                },
                'choice_label' => 'username',
                
            ])
            ->add('Note');
        ;

        if ($this->security->getUser()->getType() == 'ROLE_TEACHER'){
            $builder
            ->add('Course', EntityType::class, [
                'class' => AssocTeacherCourses::class,
                'query_builder' => function (AssocTeacherCoursesRepository $repo) {
                    return $repo->createQueryBuilder('u')
                    ->Where('u.Teacher = :val')
                    ->setParameter('val', $this->security->getUser()->getUsername())
                    ->orderBy('u.Course', 'ASC');
                },
                'choice_label' => 'Course',
                
            ])
            ;
            }else{
                $builder
                    ->add('Course', EntityType::class, [
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
            'data_class' => Notes::class,
            'csrf_protection' => false
        ]);
    }
}
