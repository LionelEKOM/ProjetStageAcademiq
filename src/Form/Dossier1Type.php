<?php

namespace App\Form;

use App\Entity\Dossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Dossier1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('clinique')
            ->add('firstname')
            ->add('lastname')
            ->add('age')
            ->add('sexe')
            ->add('email')
            ->add('adresse')
            ->add('phone')
            ->add('profession')
            ->add('taille')
            ->add('poids')
            ->add('createdAt')
            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}
