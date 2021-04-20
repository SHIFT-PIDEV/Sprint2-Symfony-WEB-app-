<?php

namespace App\Form;

use App\Entity\Examen;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\DateTime;



class ExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new DateTime('now');
        $builder
            ->add('titre')
            ->add('date', DateType::class,[
                'invalid_message' => 'You entered an invalid value, it should be bigger than today s date',
                'data' => new \DateTime("now")
            ])
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    'Facile' => 'Facile',
                    'Moyen' => 'Moyen',
                    'difficile' => 'difficile',
                ],
            ])
            ->add('prix')
            ->add('support',HiddenType::class)
            ->add('q',EntityType::class, [
        // looks for choices from this entity
        'class' => Question::class,

        'choice_label' => 'question',

    ])
            ->add('qq',EntityType::class, [
                // looks for choices from this entity
                'class' => Question::class,

                'choice_label' => 'question',

            ])
            ->add('qqq',EntityType::class, [
                // looks for choices from this entity
                'class' => Question::class,

                'choice_label' => 'question',

            ])
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Examen::class,
        ]);
    }
}
