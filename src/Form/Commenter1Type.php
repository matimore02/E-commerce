<?php

namespace App\Form;

use App\Entity\Commenter;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commenter1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'class' => 'votre-classe-titre comment-textarea', // Ajouter les classes désirées
                    'placeholder' => 'Ajouter un nouveau commentaire...', // Ajouter un placeholder
                ],
            ]);


        // Ne pas ajouter le champ de user ici
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commenter::class,
        ]);
    }
}
