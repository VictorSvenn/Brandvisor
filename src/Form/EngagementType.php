<?php

namespace App\Form;

use App\Entity\Engagement;
use App\Entity\Odd;
use App\Entity\RseCriteria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EngagementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Le nom de votre engagement : '])
            ->add('actionText', null, ['label' => 'Une explication de vos actions : '])
            ->add('actionDocuments', FileType::class, [
                'label' => 'Des documents expliquant/prouvant vos actions : ',
                'mapped' => false,
                'required' => false,
                'multiple' => 'multiple'
            ])
            ->add('resultsText', null, ['label' => 'Une explication de vos résultats : '])
            ->add('resultsDocuments', FileType::class, [
                'label' => 'Des documents expliquants/prouvant vos résultats : ',
                'mapped' => false,
                'required' => false,
                'multiple' => 'multiple'
            ])
            ->add('benefits', null, ['label' => 'Une explication des bénéfices de cet engagement : '])
            ->add('proofText', null, ['label' => 'Une preuve : '])
            ->add('proofDocuments', FileType::class, [
                'label' => 'Des documents faisant office de preuve : ',
                'mapped' => false,
                'required' => false,
                'multiple' => 'multiple'
            ])
            ->add('odd', EntityType::class, [
                'class' => Odd::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'La/les catégorie(s) odd de votre engagement : '
            ])
            ->
            add('rse', EntityType::class, [
                'class' => RseCriteria::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'La/les catégorie(s) rse de votre engagement :  '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Engagement::class,
        ]);
    }
}
