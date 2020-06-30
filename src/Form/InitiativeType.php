<?php

namespace App\Form;

use App\Entity\Initiative;
use App\Entity\Odd;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitiativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null,['label' => 'Le nom de votre initiative : '])
            ->add('illustration', null, ['label'=>'Une image pour illustrer votre initiative : '])
            ->add('presentation',null,['label'=> 'La présentation de votre initiative '])
            ->add('objective', null,['label'=> 'Les objectifs de votre initiative : '])
            ->add('detailledDescription', null, ['label' => 'Une description détaille de votre initiative : '])
            ->add('partner',null,['label' => 'Les potentiels partenaires de votre initiative : '])
            ->add('links',null,['label' => 'Un potentiel lien vers quelquechose en rapport avec votre initiative :'])
            ->add('website', null, ['label' => 'Un potentiel site web en rapport avec votre initiative : '])
            ->add('geographicArea', null, ['label'=> 'La zone géographique de votre initiative'])
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'La/les catégorie(s) odd de votre initiative : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Initiative::class,
        ]);
    }
}
