<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Cour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('nomcat',HiddenType::class)
            ->add('formateur')
            ->add('description')
            ->add('prix')
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    'Facile' => 'Facile',
                    'Moyen' => 'Moyen',
                    'difficile' => 'difficile',
                ],
            ])
            ->add('duration')
            ->add('idC' ,EntityType::class, [
        // looks for choices from this entity
        'class' => Categorie::class,

        'choice_label' => 'nomCat',

    ])
            ->add('imageFile',VichImageType::class)
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cour::class,
        ]);
    }
}
