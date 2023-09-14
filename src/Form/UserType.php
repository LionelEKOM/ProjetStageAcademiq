<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $defaultPassword = $options['data_class'] ? $options['data_class']->getPlainPassword() : '';

        $builder
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Email'],
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer une adresse e-mail.']),
                    new Email(['message' => 'Veuillez entrer une adresse e-mail valide.']),
                ],
            ])
            // ->add('roles')
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Mot de passe'],
                'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                ],
                // 'data' => $defaultPassword,
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Prénom'],
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre Prénom.']),
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom'],
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre Nom.']),
                ],
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'label' => 'Sexe',
                'choices' => [
                    'Masculin' => 'Masculin',
                    'Féminin' => 'Féminin',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un sexe.']),
                ],
            ])
            ->add('phone', TelType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => '659160779'],
                'label' => 'Téléphone',
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{9}$/',
                        'message' => 'Veuillez entrer un numéro de téléphone à 9 chiffres.',
                    ]),
                ],
            ])
            ->add('fonction', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'label' => 'Fonction',
                'choices' => [
                    'Dentiste' => 'Dentiste',
                    'Cancérologue' => 'Cancérologue',
                    'Ophtalmologue' => 'Ophtalmologue',
                    'Généraliste' => 'Généraliste',
                    'Pédiatre' => 'Pédiatre',
                    'Chirurgien' => 'Chirurgien',
                    'Administration' => 'Administration'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner une fonction.']),
                ],
            ])
            ->add('title', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'label' => 'Titre',
                'choices' => [
                    'Médecin' => 'Médecin',
                    'Infirmier' => 'Infirmier',
                    'Patient' => 'Patient',
                    'ADMIN' => 'ADMIN'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un titre.']),
                ],
            ])
            // ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
