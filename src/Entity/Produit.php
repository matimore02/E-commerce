<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_pro = null;

    #[ORM\Column]
    private ?int $prix_pro = null;

    #[ORM\Column]
    private ?int $quantite_pro = null;

    #[ORM\Column(length: 255)]
    private ?string $img_pro = null;

    #[ORM\Column(length: 511)]
    private ?string $description_pro = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CatProduit $cat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPro(): ?string
    {
        return $this->nom_pro;
    }

    public function setNomPro(string $nom_pro): static
    {
        $this->nom_pro = $nom_pro;

        return $this;
    }

    public function getPrixPro(): ?int
    {
        return $this->prix_pro;
    }

    public function setPrixPro(int $prix_pro): static
    {
        $this->prix_pro = $prix_pro;

        return $this;
    }

    public function getQuantitePro(): ?int
    {
        return $this->quantite_pro;
    }

    public function setQuantitePro(int $quantite_pro): static
    {
        $this->quantite_pro = $quantite_pro;

        return $this;
    }

    public function getImgPro(): ?string
    {
        return $this->img_pro;
    }

    public function setImgPro(string $img_pro): static
    {
        $this->img_pro = $img_pro;

        return $this;
    }

    public function getDescriptionPro(): ?string
    {
        return $this->description_pro;
    }

    public function setDescriptionPro(string $description_pro): static
    {
        $this->description_pro = $description_pro;

        return $this;
    }

    public function getCat(): ?CatProduit
    {
        return $this->cat;
    }

    public function setCat(?CatProduit $cat): static
    {
        $this->cat = $cat;

        return $this;
    }
}
