<?php

namespace App\Form;

use App\Entity\Ordonnance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt')
            ->add('title')
            ->add('medicament')
            ->add('quantite')
            ->add('debut')
            ->add('fin')
            ->add('user')
            ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
