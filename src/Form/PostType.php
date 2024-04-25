<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Post;
use App\Entity\Section;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'shadow appearance-none border rounded py-14 text-gray-700 h-40',
                ],
            ])
            ->add('imageFile', FileType::class, [
                'multiple' => false,
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image(['maxSize' => '5000k'])
                ]
            ])
            // ->add('type', EntityType::class, [
            //     'class' => Section::class,
            //     'choice_label' => 'label',
            //     'label' => 'Nous avons besoin de...',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'attr' => [
            //         'class' => 'form-check',
            //         'style' => 'display: flex;
            //         flex-direction: column-reverse;
            //         ',
            //     ]
            // ])
            ->add('type', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'label',
                'label' => 'Equipement',
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
            
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}