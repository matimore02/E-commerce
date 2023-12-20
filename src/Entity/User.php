<?php

namespace App\Entity;

use App\Repository\UserRepository;
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

    #[ORM\ManyToOne]
    private ?Pays $pays = null;

    #[ORM\Column]
    private ?int $telephone_use = null;



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

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

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


}
