<?php

namespace App\Entity;

use App\Repository\AcheterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcheterRepository::class)]
class Acheter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'acheters')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'acheters')]
    private ?Panier $panier = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdPan(): ?Panier
    {
        return $this->panier;
    }

    public function setIdPan(?Panier $panier): static
    {
        $this->panier = $panier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
