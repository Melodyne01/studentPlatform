<?php

namespace App\Form;

use App\Entity\UserPropertySearch;
use Symfony\Component\Form\AbstractType;;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserPropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class , [
                'required' => false,
            ])
            ->add('class', ChoiceType::class,[
                'choices'  => [
                    'NONE' => 'NONE',
                    'BAC1'=> 'BAC1',
                    'BAC2'=> 'BAC2',
                    'BAC3'=> 'BAC3',
                ],
                ])
            ->add('type', ChoiceType::class,[
                 'choices'  => [
                    'NONE'=> 'NONE',
                    'Student'=> 'ROLE_USER',
                    'Teacher'=> 'ROLE_TEACHER',
                    'Admin'=> 'ROLE_ADMIN',
                ],
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserPropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
