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
    private ?user $id_use = null;

    #[ORM\ManyToOne(inversedBy: 'acheters')]
    private ?panier $id_pan = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUse(): ?user
    {
        return $this->id_use;
    }

    public function setIdUse(?user $id_use): static
    {
        $this->id_use = $id_use;

        return $this;
    }

    public function getIdPan(): ?panier
    {
        return $this->id_pan;
    }

    public function setIdPan(?panier $id_pan): static
    {
        $this->id_pan = $id_pan;

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
