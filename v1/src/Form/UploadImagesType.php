<?php

namespace App\Form;

use App\Entity\ImagesCompare;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UploadImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('localPath', FileType::class,
            [
                'label' => "Pierwsze zdjecie",
                'constraints' => [
                    new File([
                        'maxSize' => '1000000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Prosze dodac dokument type JPG lub PNG',
                    ])
                ]
            ])
            ->add('localPathToCompare', FileType::class,
            [
                'label' => "Zdjecie do porownania",
                'constraints' => [
                    new File([
                        'maxSize' => '1000000k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Prosze dodac dokument type JPG lub PNG',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImagesCompare::class,
        ]);
    }
}
