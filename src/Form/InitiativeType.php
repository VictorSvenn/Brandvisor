<?php

namespace App\Form;

use App\Entity\Initiative;
use App\Entity\Odd;
use Nette\Neon\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitiativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label'=>'Le nom de l\'initiative : '
            ])
            ->add('illustration', FileType::class, [
                'label' => "Une potentielle illustration de l'initiative : ",
                'data_class' => null
            ])
            ->add('presentation', null, [
                'label' => "Une présentation de l'initiative : "
            ])
            ->add('objective', null, [
                'label' => "Le(s) objectifs de l'initiative : "
            ])
            ->add('detailledDescription', null, [
                'label'=>"Une description détaillée de l'initiative : "
            ])
            ->add('partner', null, [
                'label' => "Le(s) partenaires de l'initiative : "
            ])
            ->add('links', null, [
                'label' => "Des liens importants pour l'initiative : "
            ])
            ->add('website', null, [
                'label' => "Le site web lié à l'initiative : "
            ])
            ->add('geographicArea', null, [
                'label' => "La zone géographique de l'initiative : "
            ])
            ->add('keywords', null, [
                'label' => "Les mots clés liés à l'initiative : "
            ])
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'La/les catégorie(s) odd de l\'initiative : '
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
