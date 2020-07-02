<?php

namespace App\Form;

use App\Entity\ExpertArgumentation;
use App\Entity\Odd;
use App\Entity\RseCriteria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpertArgumentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('illustration', null, [
                'label' => 'Une illustration : '
            ])
            ->add('links', null, [
                'label' => 'Des liens :'
            ])
            ->add('keywords', null, [
                'label' => 'Des mots clés : '
            ])
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'label' => 'La (les) catégories ODD : '
            ])
            ->add('rse', EntityType::class, [
                'class' => RseCriteria::class,
                'choice_label' => 'name',
                'label' => 'La (les) catégories RSE : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpertArgumentation::class,
        ]);
    }
}
