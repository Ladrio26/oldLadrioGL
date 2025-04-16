<?php

// Inscription à la LLAN

namespace App\Form;

use App\Entity\LlanRegistration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LlanRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) // Construction d'un formulaire en mettant les différents champs dans un tableau
    {
        if (!$options['user']) {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Votre nom',
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Votre email',
                ]);
        }
        // Ne pas ajouter de bouton submit ici
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LlanRegistration::class,
            'user' => null,
        ]);
    }
}
