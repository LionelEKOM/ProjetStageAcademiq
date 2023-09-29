<?php

namespace App\Form;

use App\Entity\Antecedent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class Antecedent1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'attr' => ['class' => 'form-select', 'autofocus' => 'autofocus'],
                'label' => 'Type d\'antecedent',
                'choices' => [
                    'Antecedents Familiaux' => 'Antecedents Familiaux',
                    'Antecedents Chirugicaux' => 'Antecedents Chirugicaux',
                    'Antecedents Médicaux' => 'Antecedents Médicaux',
                    'Allergies' => 'Allergies'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un titre.']),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'La description ne doit pas être vide.'])
                ]
            ])
            // ->add('createdAt')
            // ->add('user')
            // ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Antecedent::class,
        ]);
    }
}
