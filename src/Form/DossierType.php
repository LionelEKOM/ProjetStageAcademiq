<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('clinique')
        //     ->add('firstname')
        //     ->add('lastname')
        //     ->add('age')
        //     ->add('sexe')
        //     ->add('email')
        //     ->add('adresse')
        //     ->add('phone')
        //     ->add('profession')
        //     ->add('taille')
        //     ->add('poids')
        //     ->add('createdAt')
        //     ->add('users')
        // ;

$builder
    ->add('firstname', TextType::class, [
        'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'],
        'label' => 'Prénom Patient',
        'constraints' => [
            new NotBlank(['message' => 'Veuillez entrer votre Prénom.']),
        ],
    ])
    ->add('lastname', TextType::class, [
        'attr' => ['class' => 'form-control', 'placeholder' => 'Nom'],
        'label' => 'Nom Patient',
        'constraints' => [
            new NotBlank(['message' => 'Veuillez entrer votre Nom.']),
        ],
    ])
    ->add('age', IntegerType::class, [
        'attr' => ['placeholder' => 'Age'],
        'constraints' => [
            new NotBlank(['message' => 'L\'âge ne peut pas être vide.']),
            new Range(['min' => 1, 'max' => 102, 'minMessage' => 'L\'âge doit être d\'au moins {{ limit }}.', 'maxMessage' => 'L\'âge ne peut pas dépasser {{ limit }}.']),
        ],
    ])
    ->add('sexe', ChoiceType::class, [
        'attr' => ['placeholder' => 'Sexe'],
        'choices' => [
            'Homme' => 'Homme',
            'Femme' => 'Femme',
        ],
        'constraints' => [
            new NotBlank(['message' => 'Le sexe doit être sélectionné.']),
        ],
    ])
    ->add('email', EmailType::class, [
        'attr' => ['placeholder' => 'E-mail'],
        'constraints' => [
            new NotBlank(['message' => 'L\'adresse e-mail ne peut pas être vide.']),
            new Email(['message' => 'Veuillez entrer une adresse e-mail valide.']),
        ],
    ])
    ->add('adresse', TextType::class, [
        'attr' => ['placeholder' => 'Adresse'],
        'constraints' => [
            new NotBlank(['message' => 'L\'adresse ne peut pas être vide.']),
        ],
    ])
    ->add('phone', TelType::class, [
        'attr' => ['placeholder' => 'Numero de téléphone'],
        'constraints' => [
            new NotBlank(['message' => 'Le numéro de téléphone ne peut pas être vide.']),
            new Regex(['pattern' => '/^6\d{8}$/', 'message' => 'Veuillez entrer un numéro de téléphone valide.']),
        ],
    ])
    ->add('profession', TextType::class, [
        'attr' => ['placeholder' => 'Profession'],
        'constraints' => [
            new NotBlank(['message' => 'La profession ne peut pas être vide.']),
        ],
    ])
    ->add('taille', NumberType::class, [
        'attr' => ['placeholder' => 'Taille'],
        'constraints' => [
            new NotBlank(['message' => 'La taille ne peut pas être vide.']),
            new Range(['min' => 1, 'max' => 3.03, 'minMessage' => 'La taille doit être d\'au moins {{ limit }}.', 'maxMessage' => 'La taille ne peut pas dépasser {{ limit }}.']),
        ],
    ])
    ->add('poids', NumberType::class, [
        'attr' => ['placeholder' => 'Poids'],
        'constraints' => [
            new NotBlank(['message' => 'Le poids ne peut pas être vide.']),
            new Range(['min' => 2, 'max' => 110, 'minMessage' => 'Le poids doit être d\'au moins {{ limit }}.', 'maxMessage' => 'Le poids ne peut pas dépasser {{ limit }}.']),
        ],
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
