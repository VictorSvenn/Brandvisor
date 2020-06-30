<?php

namespace App\Form;

use App\Entity\Expert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('connectingStructure')
            ->add('adress')
            ->add('phone')
            ->add('presentation')
            ->add('illustration')
            ->add('website')
            ->add('expertiseAreas')
            ->add('interventionZones')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Expert::class,
        ]);
    }
}
