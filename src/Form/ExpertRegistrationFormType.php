<?php

namespace App\Form;

use App\Entity\Expert;
use App\Entity\User;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ExpertRegistrationFormType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>"J'accepte les conditions générales d'utilisation",
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter les conditions générales d\'utilisation',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez renseigner deux mots de passes identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Votre mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
            ])
            ->add('firstName', null, [
                'label'=> "Votre prénom"
            ])
            ->add('lastName', null, [
                'label'=>"Votre nom"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
