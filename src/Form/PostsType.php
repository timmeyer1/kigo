<?php

namespace App\Form;

use App\Entity\Ads;
use App\Entity\Type;
use App\Entity\Posts;
use App\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;

class PostsType extends AbstractType
{

    // fonction pour ajouter au formulaire les champs indiqués
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control']
            ])
            ->add('section_id', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'label',
                'label' => 'Section',
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                    'class' => 'form-check',
                    'style' => 'display: flex;
                    flex-direction: column-reverse;
                    background-color: rgb(0, 86, 179, 0.1);
                    border-radius: 3px;
                    align-items: baseline;
                    ',
                ]
            ])
            
            ->add('typeId', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'label' => 'Type de bien',
                'attr' => ['class' => 'form-control']
            ])
            
            // ->add('image', CollectionType::class, [
            //     'entry_type' => UploadImageType::class,
            //     'label' => false,
            //     'allow_add' => true,
            //     'prototype' => true,
            // ]);
            ->add('imageFile', FileType::class, [
                'label' => 'Image d\'illustration (JPG, PNG, jpeg, jpg)',
                'mapped' => false,
                'attr' => ['class' => 'form-control-file']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
