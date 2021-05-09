<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Program;
use App\Entity\Technology;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('technologies', EntityType::class, [
                'class' => Technology::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'label' => false,
            ])
            ->add('programs', EntityType::class, [
                'class' => Program::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
