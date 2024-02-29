<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Etat $etat = null;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Acheter::class)]
    private Collection $acheters;

    #[ORM\OneToMany(mappedBy: 'panier', targetEntity: Composer::class)]
    private Collection $composers;

    public function __construct()
    {
        $this->acheters = new ArrayCollection();
        $this->composers = new ArrayCollection();
    }

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

    public function getIdEta(): ?Etat
    {
        return $this->etat;
    }

    public function setIdEta(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Acheter>
     */
    public function getAcheters(): Collection
    {
        return $this->acheters;
    }

    public function addAcheter(Acheter $acheter): static
    {
        if (!$this->acheters->contains($acheter)) {
            $this->acheters->add($acheter);
            $acheter->setIdPan($this);
        }

        return $this;
    }

    public function removeAcheter(Acheter $acheter): static
    {
        if ($this->acheters->removeElement($acheter)) {
            // set the owning side to null (unless already changed)
            if ($acheter->getIdPan() === $this) {
                $acheter->setIdPan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Composer>
     */
    public function getComposers(): Collection
    {
        return $this->composers;
    }

    public function addComposer(Composer $composer): static
    {
        if (!$this->composers->contains($composer)) {
            $this->composers->add($composer);
            $composer->setIdPan($this);
        }

        return $this;
    }

    public function removeComposer(Composer $composer): static
    {
        if ($this->composers->removeElement($composer)) {
            // set the owning side to null (unless already changed)
            if ($composer->getIdPan() === $this) {
                $composer->setIdPan(null);
            }
        }

        return $this;
    }
}
