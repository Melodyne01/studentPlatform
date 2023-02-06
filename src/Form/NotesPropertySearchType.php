<?php

namespace App\Form;

use App\Entity\Courses;
use App\Entity\NotesPropertySearch;
use App\Repository\CoursesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class NotesPropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('course', EntityType::class , [
                'class' => Courses::class,
                'query_builder' => function (CoursesRepository $repo) {
                    return $repo->createQueryBuilder('c')
                    ->orderBy('c.Name', 'ASC');
                },
            ])
            ->add('apply', CheckboxType::class,[
                'required' => false,
            ])

            ->add('note', ChoiceType::class , [
                'choices'  => [
                    'NONE' => 'NONE',
                    '<10' => '<10',
                    '>10'=> '>10',
                ],
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NotesPropertySearch::class,
            'csrf_protection' => false

        ]);
    }
}
