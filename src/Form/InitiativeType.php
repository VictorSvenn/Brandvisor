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
            ->add('name', null, [
                'label'=>'Le nom de votre initiative : '
            ])
            ->add('illustration', null, [
                'label' => "Une potentielle illustration de votre initiative : "
            ])
            ->add('presentation', null, [
                'label' => "Une présentation de votre initiative : "
            ])
            ->add('objective', null, [
                'label' => "Le(s) objectifs de votre initiative : "
            ])
            ->add('detailledDescription', null, [
                'label'=>"Une description détaillée de votre initiative : "
            ])
            ->add('partner', null, [
                'label' => "Le(s) partenaires de cette initiative : "
            ])
            ->add('links', null, [
                'label' => "Des liens importants pour cette initiative : "
            ])
            ->add('website', null, [
                'label' => "Le site web lié a votre initiative : "
            ])
            ->add('geographicArea', null, [
                'label' => "La zone géographique de votre initiative : "
            ])
            ->add('keywords', null, [
                'label' => "Les mots clés liés à votre initiative : "
            ])
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
