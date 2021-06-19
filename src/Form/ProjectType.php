<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Techno;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('yearStart')
            ->add('description')
            // https://symfony.com/doc/current/reference/forms/types/collection.html
            ->add('features', CollectionType::class, [
                // each entry in the array will be a "text" field
                'entry_type' => TextType::class,
                // these options are passed to each "text" type
                'entry_options' => [
                    'attr' => ['class' => 'feature-input']
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
            ])
            ->add('gitLink')
            ->add('webLink')
            ->add('images', CollectionType::class, [
                // each entry in the array will be a "text" field
                'entry_type' => TextType::class,
                // these options are passed to each "text" type
                'entry_options' => [
                    'attr' => ['class' => 'images-input']
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'prototype' => true,
            ])
            ->add('techno', EntityType::class, [
                'class' => Techno::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
