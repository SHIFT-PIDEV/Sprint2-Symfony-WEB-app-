<?php

namespace App\Form;

use App\Entity\Examen;
use App\Entity\Inscripexam;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscripexamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('idexam',EntityType::class, [
                // looks for choices from this entity
                'class' => Examen::class,

                'choice_label' => 'titre',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscripexam::class,
        ]);
    }
}
