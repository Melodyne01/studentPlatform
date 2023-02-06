<?php

namespace App\Form;

use App\Entity\UE;
use App\Entity\Courses;
use App\Entity\User;
use App\Repository\UERepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CourseType extends AbstractType
{   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('UE', EntityType::class, [
                'class' => UE::class,
                'query_builder' => function (UERepository $er) {
                    return $er->createQueryBuilder('u')
                    ->orderBy('u.Name', 'ASC');
                },
                
            ])
            ->add('Name')
            
            ->add('CourseKey')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Courses::class,
            'csrf_protection' => false

        ]);
    }

    
}
