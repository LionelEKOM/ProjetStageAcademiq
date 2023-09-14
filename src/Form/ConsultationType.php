<?php

namespace App\Form;

use App\Entity\Consultation;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt')
            ->add('motif')
            ->add('traitant', EntityType::class, [
                'class' => User::class, // L'entité que vous souhaitez afficher dans le select
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.title LIKE :title')
                        ->setParameter('title', '%Médecin%')
                        ->orderBy('u.id', 'ASC'); // Vous pouvez trier les résultats si nécessaire
                },
                'choice_label' => 'firstname', // L'attribut de l'entité à afficher dans la liste déroulante
                'placeholder' => 'Sélectionnez Le medecin traitant', // Texte affiché par défaut
                'attr' => ['class' => 'form-control'], // Classe CSS pour le champ select
                'label' => 'Medecin Traitant'
            ])
            // ->add('user')
            ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
