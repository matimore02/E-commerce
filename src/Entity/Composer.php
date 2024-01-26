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
    private ?Panier $id_pan = null;

    #[ORM\ManyToOne(inversedBy: 'composers')]
    private ?Produit $id_pro = null;

    #[ORM\Column]
    private ?int $Quantité = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPan(): ?Panier
    {
        return $this->id_pan;
    }

    public function setIdPan(?Panier $id_pan): static
    {
        $this->id_pan = $id_pan;

        return $this;
    }

    public function getIdPro(): ?Produit
    {
        return $this->id_pro;
    }

    public function setIdPro(?Produit $id_pro): static
    {
        $this->id_pro = $id_pro;

        return $this;
    }

    public function getQuantité(): ?int
    {
        return $this->Quantité;
    }

    public function setQuantité(int $Quantité): static
    {
        $this->Quantité = $Quantité;

        return $this;
    }
}
