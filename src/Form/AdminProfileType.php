<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AdminProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,
            [
                'label' => "Pseudonim",
                'attr'=> 
                [
                    "placeholder" => "Twoj pseudonim"
                ]
            ])
            ->add('password', RepeatedType::class,
            [
                'type' => PasswordType::class,
                'invalid_message' => "Oba hasla sie nie zgadzaja",
                'first_options'  => 
                [
                    'label' => 'Haslo'
                ],
                'second_options' => 
                [
                    'label' => 'Potwierdz haslo'
                ],
            ])
            ->add('save', SubmitType::class,
            [
                'label' => "Zatwierdz"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
