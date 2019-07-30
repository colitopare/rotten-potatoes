<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Adresse email",
                'attr' => [
                    'placeholder' => "Votre adresse email"
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => "Mot de passe",
                'attr' => [
                    'placeholder' => "Choisisez un mot de passe"
                ]
            ])
            ->add('name', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Votre nom"
                ]
            ])
            ->add('avatar', UrlType::class, [
                'label' => "Avatar",
                'attr' => [
                    'placeholder' => "Votre avatar"
                ],
                'default_protocol' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
