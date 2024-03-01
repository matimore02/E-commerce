<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance_use = null;

    #[ORM\Column(length: 30)]
    private ?string $nom_use = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom_use = null;


    #[ORM\Column]
    private ?int $telephone_use = null;

    #[ORM\OneToMany(mappedBy: 'id_use', targetEntity: Panier::class)]
    private Collection $paniers;

    #[ORM\OneToMany(mappedBy: 'id_use', targetEntity: Acheter::class)]
    private Collection $acheters;

    #[ORM\OneToMany(mappedBy: 'id_use', targetEntity: Noter::class)]
    private Collection $noters;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Adresse::class)]
    private Collection $adresses;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commenter::class, orphanRemoval: true)]
    private Collection $commenters;

    #[ORM\Column]
    private ?int $admin = null;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
        $this->acheters = new ArrayCollection();
        $this->noters = new ArrayCollection();
        $this->adresses = new ArrayCollection();
        $this->commenters = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateNaissanceUse(): ?\DateTimeInterface
    {
        return $this->date_naissance_use;
    }

    public function setDateNaissanceUse(\DateTimeInterface $date_naissance_use): static
    {
        $this->date_naissance_use = $date_naissance_use;

        return $this;
    }

    public function getNomUse(): ?string
    {
        return $this->nom_use;
    }

    public function setNomUse(string $nom_use): static
    {
        $this->nom_use = $nom_use;

        return $this;
    }

    public function getPrenomUse(): ?string
    {
        return $this->prenom_use;
    }

    public function setPrenomUse(string $prenom_use): static
    {
        $this->prenom_use = $prenom_use;

        return $this;
    }



    public function getTelephoneUse(): ?int
    {
        return $this->telephone_use;
    }

    public function setTelephoneUse(int $telephone_use): static
    {
        $this->telephone_use = $telephone_use;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setIdUse($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getIdUse() === $this) {
                $panier->setIdUse(null);
            }
        }

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
            $acheter->setIdUse($this);
        }

        return $this;
    }

    public function removeAcheter(Acheter $acheter): static
    {
        if ($this->acheters->removeElement($acheter)) {
            // set the owning side to null (unless already changed)
            if ($acheter->getIdUse() === $this) {
                $acheter->setIdUse(null);
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
            $noter->setIdUse($this);
        }

        return $this;
    }

    public function removeNoter(Noter $noter): static
    {
        if ($this->noters->removeElement($noter)) {
            // set the owning side to null (unless already changed)
            if ($noter->getIdUse() === $this) {
                $noter->setIdUse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Adresse>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setUser($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): static
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUser() === $this) {
                $adress->setUser(null);
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
            $commenter->setUser($this);
        }

        return $this;
    }

    public function removeCommenter(Commenter $commenter): static
    {
        if ($this->commenters->removeElement($commenter)) {
            // set the owning side to null (unless already changed)
            if ($commenter->getUser() === $this) {
                $commenter->setUser(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?int
    {
        return $this->admin;
    }

    public function setAdmin(int $admin): static
    {
        $this->admin = $admin;

        return $this;
    }


}
