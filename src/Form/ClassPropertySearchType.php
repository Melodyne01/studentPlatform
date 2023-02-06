<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Courses;
use App\Repository\UserRepository;
use App\Entity\ClassPropertySearch;
use App\Repository\CoursesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClassPropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('class', ChoiceType::class , [
                'choices'  => [
                    'BAC1' => 'BAC1',
                    'BAC2' => 'BAC2',
                    'BAC3'=> 'BAC3',
                ],
                
            ])
            ->add('course', EntityType::class, [
                'required' => false,
                'class' => Courses::class,
                'query_builder' => function (CoursesRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.Name', 'ASC');
                },
                'choice_label' => 'Name',
                'placeholder' => 'Filter by course',

                
            ])
            ->add('student', EntityType::class, [
                'required' => false,
                'class' => User::class,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')
                    ->Where('u.Type = :val')
                    ->setParameter('val', 'ROLE_USER')
                    ->orderBy('u.username', 'ASC');
                },
                'choice_label' => 'username',
                'placeholder' => 'Filter by student',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassPropertySearch::class,
            'csrf_protection' => false

        ]);
    }
}
