<?php

namespace App\Form;

use App\Entity\Enterprise;
use App\Entity\Opinion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpinionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', null, [
                'label' => 'Votre commentaire : '
            ])
            ->add('enterprise', EntityType::class, [
                'class' => Enterprise::class,
                'choice_label' => 'name',
                'label' => "L'entreprise visée : "
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opinion::class,
        ]);
    }
}
