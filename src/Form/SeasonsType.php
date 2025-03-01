<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Seasons;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('year')
            ->add('numbersOfEpisode')
            ->add('description')
            ->add('program_id', EntityType::class, [
                'class' => Program::class,
                'choice_label' => 'title',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seasons::class,
        ]);
    }
}
