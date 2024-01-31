<?php

namespace App\Entity;

use App\Repository\NoterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoterRepository::class)]
class Noter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'noters')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'noters')]
    private ?Produit $produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getIdUse(): ?User
    {
        return $this->user;
    }

    public function setIdUse(?User $user): static
    {
        $this->user = $user;

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
}
