<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactNlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('naam', TextType::class, [
            'attr' => [
                'placeholder' => "Uw naam",
            ]
        ])
        ->add('voornaam', TextType::class, [
            'attr' => [
                'placeholder' => "Uw voornaam",
            ]
        ])
        ->add('email', TextType::class, [
            'attr' => [
                'placeholder' => "Uw email of telephonnumer",
            ]
        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => "Wat is uw bericht?"
            ]
        ])
        ->add('save', SubmitType::class, [
            'label' => "Sturen"
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
