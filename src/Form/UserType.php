<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'class' => 'mt-5',
                    'placeholder' => 'Entrez votre email'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'class' => 'mt-3',
                    'placeholder' => 'Entrez votre numéro de téléphone'
                ]
            ])
            ->add('section', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'label',
                'label' => 'Equipement',
                'multiple' => false,
                'expanded' => false, // Passe à false pour un menu déroulant
                'attr' => [
                    'class' => 'form-control', // Utilise la classe form-control pour un menu déroulant
                ],
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'Votre email',
                'attr' => [
                    'class' => 'mt-5',
                    'placeholder' => 'Ajouter une bio'
                ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
