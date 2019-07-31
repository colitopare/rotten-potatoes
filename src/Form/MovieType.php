<?php

namespace App\Form;

use App\Entity\Movie;
use App\Entity\People;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MovieType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', TextType::class, [
        'label' => "Titre",
        'attr' => [
          'placeholder' => "Ecrire le titre du film"
        ]
      ])
      ->add('poster', UrlType::class, [
        'default_protocol' => '',
        'label' => "Affiche",
        'attr' => [
          'placeholder' => "Url de l'affiche du film"
        ]
      ])
      ->add('releasedAt', DateTimeType::class, [
        'label' => "Date de sortie",
        'attr' => [
          'placeholder' => "Mettre la date de sortie du film"
        ]
      ])
      ->add('synopsis', TextareaType::class, [
        'label' => "Résumé",
        'attr' => [
          'placeholder' => "Le résumé du film film"
        ]
      ])
      ->add('categories', EntityType::class, [
        'label' => "Catégories",
        'class' => Category::class,
        'choice_label' => 'title',
        'multiple' => true,
        'expanded' => true,
        'attr' => [
          'placeholder' => "Dans qu'elle(s) catégorie(s) placé ce film"
        ]
      ])
      ->add('director', EntityType::class, [
        'label' => "Réalisateur",
        'class' => People::class,
        'choice_label' => 'fullName',
        'expanded' => true,
        'attr' => [
          'placeholder' => "Le réalisateur de ce film"
        ]
      ])
      ->add('actors', EntityType::class, [
        'label' => "Acteurs",
        'class' => People::class,
        'choice_label' => 'fullName',
        'multiple' => true,
        'expanded' => true,
        'attr' => [
          'placeholder' => "Les acteurs de ce film"
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => Movie::class,
    ]);
  }
}
