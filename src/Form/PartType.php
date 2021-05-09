<?php

namespace App\Form;

use App\Entity\Part;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('introduction', TextareaType::class)
            ->add('description', TextareaType::class)
            ->add('exercise', TextareaType::class)
            ->add('solution', TextareaType::class)
            ->add('saveAndAdd', SubmitType::class, ['label' => 'Sauvegarder et ajouter une partie'])
            ->add('save', SubmitType::class, ['label' => 'Créer la partie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Part::class,
        ]);
    }
}
