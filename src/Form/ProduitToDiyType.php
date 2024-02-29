<?php

namespace App\Form;

use App\Entity\Diy;
use App\Entity\Produit;
use App\Entity\ProduitToDiy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitToDiyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
'choice_label' => 'id',
            ])
            ->add('diy', EntityType::class, [
                'class' => Diy::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProduitToDiy::class,
        ]);
    }
}
