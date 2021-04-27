<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Cour;
use App\Entity\Package;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nompackage')
            ->add('prix')
            ->add('duree')
            ->add('description')
            ->add('categorie',HiddenType::class)
            ->add('nbrcours')
            ->add('idca', EntityType::class, [
                // looks for choices from this entity
                'class' => Categorie::class,

                'choice_label' => 'nomCat',

            ])
            ->add('courp', EntityType::class, [
                // looks for choices from this entity
                'class' => Cour::class,

                'choice_label' => 'nom',

            ])
            ->add('courpp', EntityType::class, [
                // looks for choices from this entity
                'class' => Cour::class,

                'choice_label' => 'nom',

            ])
            ->add('courppp', EntityType::class, [
                // looks for choices from this entity
                'class' => Cour::class,

                'choice_label' => 'nom',

            ])

            ->add('image',FileType::class,[
        'label'=>'image',
        'mapped'=>false,
        'required'=>false
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
        ]);
    }
}
