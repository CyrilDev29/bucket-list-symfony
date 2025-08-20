<?php

namespace App\Form;

use App\Entity\Wish;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Votre idée',
                'attr' => [
                    'placeholder' => 'Entrez le titre de votre souhait...'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Décrivez-le !',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Décrivez votre souhait en détail...',
                    'rows' => 4
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Votre nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Votre nom...'
                ]
            ])
            // NOUVEAU : Champ de sélection de catégorie
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name', // Affiche le nom de la catégorie
                'label' => 'Catégorie',
                'placeholder' => '-- Choisissez une catégorie --',
                'required' => false,
                'attr' => [
                    'class' => 'form-select' // Classe Bootstrap pour le select
                ]
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publié',
                'required' => false,
                'data' => true // Coché par défaut
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter mon souhait !',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}