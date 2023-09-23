<?php

namespace App\Form;

use App\Entity\Ordonnance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt')
            // ->add('title')
            ->add('medicament', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom du médicament ne peut pas être vide.']),
                ],
            ])
            
            ->add('quantite', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le nom du médicament ne peut pas être vide.']),
                    new LessThanOrEqual(['value' => 3, 'message' => 'La quantité ne doit pas excéder 3.']),
                ],
            ])
            
            // ->add('debut', DateType::class, [
            //     'constraints' => [
            //         new NotBlank(['message' => 'La date de début du traitement ne peut pas être vide.']),
            //     ],
            // ])
            
            ->add('fin', DateType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'La date de fin du traitement ne peut pas être vide.']),
                ],
            ])
            
            // ->add('user')
            // ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
