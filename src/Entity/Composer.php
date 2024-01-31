<?php

namespace App\Entity;

use App\Repository\ComposerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposerRepository::class)]
class Composer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'composers')]
    private ?Panier $panier = null;

    #[ORM\ManyToOne(inversedBy: 'composers')]
    private ?Produit $produit = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPan(): ?Panier
    {
        return $this->panier;
    }

    public function setIdPan(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }

    public function getIdPro(): ?Produit
    {
        return $this->produit;
    }

    public function setIdPro(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
}
