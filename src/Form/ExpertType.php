<?php

namespace App\Form;

use App\Entity\Expert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ExpertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('connectingStructure', null, [
                'label' => 'Votre structure de rattachement : '
            ])
            ->add('adress', null, [
                'label' => 'Votre adresse : '
            ])
            ->add('phone', null, [
                'label' => 'Votre numéro de téléphone : '
            ])
            ->add('presentation', null, [
                'label' => 'Une rapide présentation de vous même : '
            ])
            ->add('illustration', FileType::class, [
                'label' => 'Votre photo de profil / illustration :',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                    ])
                ]
            ])
            ->add('website', null, [
                'label' => 'Site web de l\'entreprise : '
            ])
            ->add('expertiseAreas', null, [
                'label' => 'Vos domaines d\'expertise : '
            ])
            ->add('interventionZones', null, [
                'label'=>'Vos zones d\'intervention : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expert::class,
        ]);
    }
}
