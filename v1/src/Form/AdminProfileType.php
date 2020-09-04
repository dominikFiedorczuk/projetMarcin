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
                'label' => "Nazwa użytkownika",
                'attr'=> 
                [
                    "placeholder" => "Nazwa użytkownika ..."
                ]
            ])
            ->add('password', RepeatedType::class,
            [
                'type' => PasswordType::class,
                'invalid_message' => "Hasła się nie zgadzają ...",
                'first_options'  => 
                [
                    'label' => 'Hasło'
                ],
                'second_options' => 
                [
                    'label' => 'Potwierdż hasło'
                ],
            ])
            ->add('save', SubmitType::class,
            [
                'label' => "Zatwierdż"
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
