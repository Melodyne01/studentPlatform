<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('class', ChoiceType::class,[
                'choices'  => [
                    'BAC1'=> 'BAC1',
                    'BAC2'=> 'BAC2',
                    'BAC3'=> 'BAC3',
                ],
                ])
            ->add('type', ChoiceType::class,[
                'choices'  => [
                    'Student' => 'ROLE_USER',
                    'Teacher' => 'ROLE_TEACHER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                ])
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
