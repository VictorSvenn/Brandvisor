<?php

namespace App\Form;

use App\Entity\Engagement;
use App\Entity\Odd;
use App\Entity\RseCriteria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EngagementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('actionText')
            ->add('actionDocuments')
            ->add('resultsText')
            ->add('resultsDocuments')
            ->add('benefits')
            ->add('proofText')
            ->add('proofDocuments')
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->
            add('rse', EntityType::class, [
                'class' => RseCriteria::class,
                'choice_label' => 'name',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Engagement::class,
        ]);
    }
}
