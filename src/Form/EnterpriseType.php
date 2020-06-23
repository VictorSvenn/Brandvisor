<?php

namespace App\Form;

use App\Controller\SecurityController;
use App\Entity\Consumer;
use App\Entity\Enterprise;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class EnterpriseType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $email = '';
        if ($this->security->getUser()) {
            $email = $this->security->getUser()->getUsername();
        }
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('adress', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('contactFunction', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('website', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('siret', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('logo', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('enterprisePhone', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('enterprisePres', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('documents', null, [
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']])
            ->add('type', EntityType::class, [
                'class' => \App\Entity\EnterpriseType::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'fullName',
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']
            ])
            ->add('email', null, [
                'mapped' => false,
                'data' => $email,
                'attr' => ['class' => 'form-control', 'style' => 'width:100%']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enterprise::class,
        ]);
    }
}
