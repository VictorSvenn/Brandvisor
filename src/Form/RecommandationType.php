<?php

namespace App\Form;

use App\Entity\Recommandation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RecommandationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstLink', TextType::class, [
                'label'=>'Premier lien :',
            ])
            ->add('firstImage', FileType::class, [
                'label'=>'Première image :',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('secondLink', TextType::class, [
                'label'=>'Second lien :',
            ])
            ->add('secondImage', FileType::class, [
                'label'=>'Seconde image :',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('thirdLink', TextType::class, [
                'label'=>'Troisième lien :',
            ])
            ->add('thirdImage', FileType::class, [
                'label'=>'Troisième image :',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('fourthLink', TextType::class, [
                'label'=>'Quatrième lien :',
            ])
            ->add('fourthImage', FileType::class, [
                'label'=>'Quatrième image :',
                'mapped'=>false,
                'required'=>false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recommandation::class,
        ]);
    }
}
