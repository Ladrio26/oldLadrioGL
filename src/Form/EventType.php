<?php

// Création d'un événement sur le site (event)

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) // Construction d'un formulaire en mettant les différents champs dans un tableau
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextType::class, ['label' => 'Description'])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'html5' => false,
                'label' => 'Date et Heure',
                'attr' => [
                    'placeholder' => 'AAAA-MM-DD HH:MM:SS (année-mois-jour heure:minutes:secondes)',
                ],
                'help' => 'Format attendu : AAAA-MM-DD HH:MM:SS (année-mois-jour heure:minutes:secondes)',
            ])
            ->add('jeu', ChoiceType::class, [
                'choices' => [
                    'Among Us' => 'Among Us',
                    'League of Legends' => 'League of Legends',
                    'TFT' => 'TFT',
                    'Rocket League' => 'Rocket League',
                    // Add other games as needed
                ],
                'label' => 'Jeu'
            ])
            ->add('save', SubmitType::class, ['label' => 'Créer un événement']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
