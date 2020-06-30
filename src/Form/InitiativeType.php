<?php

namespace App\Form;

use App\Entity\Initiative;
use App\Entity\Odd;
use Nette\Neon\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitiativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('illustration')
            ->add('presentation')
            ->add('objective')
            ->add('detailledDescription')
            ->add('partner')
            ->add('links')
            ->add('website')
            ->add('geographicArea')
            ->add('keywords')
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'La/les catégorie(s) odd de votre initiative : '
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Initiative::class,
        ]);
    }
}
