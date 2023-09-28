<?php

namespace App\Form;

use App\Entity\Rdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RdvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date', DateType::class, [
            'label' => 'Date du RDV',
            'constraints' => [
                new NotBlank(['message' => 'La date du RDV ne peut pas être vide.']),
            ],
            'attr' => [
                'placeholder' => 'Sélectionnez une date',
            ],
        ])
        ->add('motif', TextType::class, [
            'label' => 'Motif',
            'constraints' => [
                new NotBlank(['message' => 'Le motif ne peut pas être vide.']),
            ],
            'attr' => [
                'placeholder' => 'Saisissez le motif',
            ],
        ])
        // ... Ajoutez d'autres champs au besoin
        // ->add('user')
        // ->add('dossier')
    ;    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
        ]);
    }
}
