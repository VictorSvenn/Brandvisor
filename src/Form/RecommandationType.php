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
            ->add('firstLink', TextType::class)
            ->add('firstImage', FileType::class, [
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('secondLink', TextType::class)
            ->add('secondImage', FileType::class, [
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('thirdLink', TextType::class)
            ->add('thirdImage', FileType::class, [
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('fourthLink', TextType::class)
            ->add('fourthImage', FileType::class, [
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
