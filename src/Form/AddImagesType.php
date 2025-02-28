<?php

namespace App\Form;

use App\Form\UploadImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', CollectionType::class, [
                'entry_type' => UploadImagesType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'label' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => "Dodaj zdjecia",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
