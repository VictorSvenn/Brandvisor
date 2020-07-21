<?php

namespace App\Form;

use App\Entity\Expert;
use App\Entity\User;
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

class EtpRegistrationFormType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, [
                'label'=> "Votre email"
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => "J'accepte les conditions générales d'utilisation"
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Votre mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
            ])
            ->add(
                'etpname',
                null,
                ['mapped' => false,
                    'label' => 'Le nom de votre entreprise']
            )
            ->add(
                'SIRET',
                null,
                ['mapped' => false,
                    'label'=> 'Le numéro de SIRET pour votre entreprise']
            )
            ->add(
                'contact_fct',
                null,
                ['mapped' => false,
                    'label' => 'Votre poste au sein de cette entreprise']
            )
            ->add('firstName', null, [
                'label' => 'Votre prénom'
            ])
            ->add('lastName', null, [
                'label' => 'Votre nom'
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
