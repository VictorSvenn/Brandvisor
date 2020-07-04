<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Enterprise;
use App\Entity\Engagement;
use App\Entity\Challenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array('label' => 'Nom du challenge'))
            ->add('enterprise', EntityType::class, array(
                'class' => Enterprise::class,
                'choice_label' => 'name',
                'label' => "L'entreprise visée"
            ))
            ->add('engagement', EntityType::class, array(
                'label' => 'Engagement',
                'class' => Engagement::class,
                'choice_label' => 'name',
                'required' => false
                ))
            ->add('description', null, array('label' => 'Description'))
            ->add('comment', null, array('label' => 'Commentaire'))
            ->add('documents', FileType::class, array(
                'label' => 'Documents',
                'required' => false,
                'multiple' => 'multiple'))
            ->add('isConform', null, array('label' => 'Mon challenge est conforme à la charte'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}
