<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'id_pro', targetEntity: Composer::class)]
    private Collection $composers;

    #[ORM\OneToMany(mappedBy: 'id_pro', targetEntity: Noter::class)]
    private Collection $noters;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commenter::class, orphanRemoval: true)]
    private Collection $commenters;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitToDiy::class)]
    private Collection $produitToDiys;

    public function __construct()
    {
        $this->composers = new ArrayCollection();
        $this->noters = new ArrayCollection();
        $this->commenters = new ArrayCollection();
        $this->produitToDiys = new ArrayCollection();
    }

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
            $composer->setIdPro($this);
        }

        return $this;
    }

    public function removeComposer(Composer $composer): static
    {
        if ($this->composers->removeElement($composer)) {
            // set the owning side to null (unless already changed)
            if ($composer->getIdPro() === $this) {
                $composer->setIdPro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Noter>
     */
    public function getNoters(): Collection
    {
        return $this->noters;
    }

    public function addNoter(Noter $noter): static
    {
        if (!$this->noters->contains($noter)) {
            $this->noters->add($noter);
            $noter->setIdPro($this);
        }

        return $this;
    }

    public function removeNoter(Noter $noter): static
    {
        if ($this->noters->removeElement($noter)) {
            // set the owning side to null (unless already changed)
            if ($noter->getIdPro() === $this) {
                $noter->setIdPro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commenter>
     */
    public function getCommenters(): Collection
    {
        return $this->commenters;
    }

    public function addCommenter(Commenter $commenter): static
    {
        if (!$this->commenters->contains($commenter)) {
            $this->commenters->add($commenter);
            $commenter->setProduit($this);
        }

        return $this;
    }

    public function removeCommenter(Commenter $commenter): static
    {
        if ($this->commenters->removeElement($commenter)) {
            // set the owning side to null (unless already changed)
            if ($commenter->getProduit() === $this) {
                $commenter->setProduit(null);
            }
        }

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
            $produitToDiy->setProduit($this);
        }

        return $this;
    }

    public function removeProduitToDiy(ProduitToDiy $produitToDiy): static
    {
        if ($this->produitToDiys->removeElement($produitToDiy)) {
            // set the owning side to null (unless already changed)
            if ($produitToDiy->getProduit() === $this) {
                $produitToDiy->setProduit(null);
            }
        }

        return $this;
    }
}
