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
            ->add('name', null, [
                'label' => 'Le nom de votre entreprise : '
            ])
            ->add('adress', null, [
                'label' => "L'adresse de votre entreprise : "
            ])
            ->add('contactFunction', null, [
                'label' => 'Votre fonction au sein de cette entreprise : '
            ])
            ->add('website', null, [
                'label' => "Un lien vers votre site web"
            ])
            ->add('siret', null, [
                'label' => "Le numéro SIRET de votre entreprise : "
            ])
            ->add('logo', FileType::class, [
                'label' => 'Le logo de votre entreprise : ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                    ])
                ]
            ])
            ->add('enterprisePhone', null, [
                'label' => "Le numéro de téléphone de votre entreprise :"
            ])
            ->add('enterprisePres', null, [
                'label' => "Une présentation de votre entreprise :"
            ])
            ->add('document_list', FileType::class, [
                'label' => 'Les documents utiles de votre entreprise : ',
                'mapped' => false,
                'required' => false,
                'multiple' => 'multiple',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enterprise::class,
        ]);
    }
}
