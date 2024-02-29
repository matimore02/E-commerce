<?php

namespace App\Entity;

use App\Repository\ProduitToDiyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitToDiyRepository::class)]
class ProduitToDiy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'produitToDiys')]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'produitToDiys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Diy $diy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getDiy(): ?Diy
    {
        return $this->diy;
    }

    public function setDiy(?Diy $diy): static
    {
        $this->diy = $diy;

        return $this;
    }
}
