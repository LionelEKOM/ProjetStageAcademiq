<?php

namespace App\Form;

use App\Entity\Examen;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt')
            ->add('type', ChoiceType::class, [
                'attr' => ['autofocus' => 'autofocus'],
                'label' => 'Type d\'Examen',
                'choices' => [
                    'Examens de laboratoire' => 'Examens de laboratoire',
                    'Imagerie médicale' => 'Imagerie médicale',
                    'Examens cardiaques' => 'Examens cardiaques',
                    'Examens respiratoires' => 'Examens respiratoires',
                    'Examens neurologiques' => 'Examens neurologiques',
                    'Examens gynécologiques' => 'Examens respiratoires',
                    'Examens dermatologiques' => 'Examens dermatologiques'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un titre.']),
                ],
            ])

            ->add('resultat', TextareaType::class, [
                // 'attr' => ['class' => 'form-control'],
                'label' => 'Description',
                'constraints' => [
                    new NotBlank(['message' => 'La description ne doit pas être vide.'])
                ]
            ])
            // ->add('resultat')
            // ->add('user')
            // ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Examen::class,
        ]);
    }
}
