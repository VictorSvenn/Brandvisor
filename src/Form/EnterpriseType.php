<?php

namespace App\Form;

use App\Entity\Enterprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EnterpriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('adress')
            ->add('contactFunction')
            ->add('website')
            ->add('siret')
            ->add('logo', FileType::class, [
                'label' => 'Votre logo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                    ])
                ]
            ])
            ->add('enterprisePhone')
            ->add('enterprisePres')
            ->add('document_list', FileType::class, [
                'label' => 'Vos documents utiles',
                'mapped' => false,
                'required' => false,
                'multiple'=> 'multiple',
//                'constraints' => [
//                    new File([
//                        'mimeTypes' => 'application/png',
//                        'mimeTypesMessage' => 'Please upload a valid PDF document'
//                    ])
//                ],
            ])
            ->add('type', EntityType::class, [
                'class' => \App\Entity\EnterpriseType::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enterprise::class,
        ]);
    }
}
