<?php

namespace App\Entity;

use App\Repository\DiyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiyRepository::class)]
class Diy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_diy = null;

    #[ORM\Column(length: 10)]
    private ?string $prix_diy = null;

    #[ORM\Column(length: 512)]
    private ?string $description_diy = null;

    #[ORM\OneToMany(mappedBy: 'diy', targetEntity: ProduitToDiy::class)]
    private Collection $produitToDiys;

    public function __construct()
    {
        $this->produitToDiys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDiy(): ?string
    {
        return $this->nom_diy;
    }

    public function setNomDiy(string $nom_diy): static
    {
        $this->nom_diy = $nom_diy;

        return $this;
    }

    public function getPrixDiy(): ?string
    {
        return $this->prix_diy;
    }

    public function setPrixDiy(string $prix_diy): static
    {
        $this->prix_diy = $prix_diy;

        return $this;
    }

    public function getDescriptionDiy(): ?string
    {
        return $this->description_diy;
    }

    public function setDescriptionDiy(string $description_diy): static
    {
        $this->description_diy = $description_diy;

        return $this;
    }

    /**
     * @return Collection<int, ProduitToDiy>
     */
    public function getProduitToDiys(): Collection
    {
        return $this->produitToDiys;
    }

    public function addProduitToDiy(ProduitToDiy $produitToDiy): static
    {
        if (!$this->produitToDiys->contains($produitToDiy)) {
            $this->produitToDiys->add($produitToDiy);
            $produitToDiy->setDiy($this);
        }

        return $this;
    }

    public function removeProduitToDiy(ProduitToDiy $produitToDiy): static
    {
        if ($this->produitToDiys->removeElement($produitToDiy)) {
            // set the owning side to null (unless already changed)
            if ($produitToDiy->getDiy() === $this) {
                $produitToDiy->setDiy(null);
            }
        }

        return $this;
    }
}
