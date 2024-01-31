<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville_adr = null;

    #[ORM\Column]
    private ?int $cp_adr = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complement_adr = null;

    #[ORM\Column(length: 255)]
    private ?string $rue_adr = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pays $pays = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleAdr(): ?string
    {
        return $this->ville_adr;
    }

    public function setVilleAdr(?string $ville_adr): static
    {
        $this->ville_adr = $ville_adr;

        return $this;
    }

    public function getCpAdr(): ?int
    {
        return $this->cp_adr;
    }

    public function setCpAdr(int $cp_adr): static
    {
        $this->cp_adr = $cp_adr;

        return $this;
    }

    public function getComplementAdr(): ?string
    {
        return $this->complement_adr;
    }

    public function setComplementAdr(?string $complement_adr): static
    {
        $this->complement_adr = $complement_adr;

        return $this;
    }

    public function getRueAdr(): ?string
    {
        return $this->rue_adr;
    }

    public function setRueAdr(string $rue_adr): static
    {
        $this->rue_adr = $rue_adr;

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
