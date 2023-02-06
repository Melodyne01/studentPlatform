<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Courses;
use App\Repository\UserRepository;

use App\Entity\RegistrationToCourse;
use App\Repository\CoursesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationToCourseType extends AbstractType
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
                'choice_label' => 'Name',

            ])

            ->add('CourseKey', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RegistrationToCourse::class,
            'csrf_protection' => false
        ]);
    }
}
