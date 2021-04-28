<?php

namespace App\Form;

use App\Entity\Paymentmethod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('pays' , ChoiceType::class, [
                'choices'  => [
                    'Choose ...' => 'NULL',
                    'United States' => 'United States',
                ],
            ])
            ->add('codepostal')
            ->add('numcarte')
            ->add('cvc')
            ->add('datecarte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paymentmethod::class,
        ]);
    }
}
