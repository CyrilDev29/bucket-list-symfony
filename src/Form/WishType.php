<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Votre idée',
                'attr' => [
                    'placeholder' => 'Entrez le titre de votre souhait...',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Décrivez-le !',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Décrivez votre souhait en détail...',
                    'rows' => 4,
                    'class' => 'form-control'
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Votre nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Votre nom...',
                    'class' => 'form-control'
                ]
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publié',
                'required' => false,
                'data' => true,
                'attr' => [
                    'class' => 'form-check-input'
                ]
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