<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: "Il y a déjà un compte avec cette adresse email.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'adresse email n'est pas valide.")]
    #[Assert\Length(max: 180)]
    private ?string $email = null;

    /**
     * @var Collection<int, Role> The user roles
     */
    #[ORM\ManyToMany(targetEntity: Role::class)]
    private Collection $userRoles;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le prénom ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $firstName = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $lastName = null;

    /**
     * @var Collection<int, Internship>
     */
    #[ORM\OneToMany(targetEntity: Internship::class, mappedBy: 'trackingTeacher')]
    private Collection $trackingInternships;

    /**
     * @var Collection<int, Internship>
     */
    #[ORM\OneToMany(targetEntity: Internship::class, mappedBy: 'visitingTeacher')]
    private Collection $visitingInternships;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
        $this->trackingInternships = new ArrayCollection();
        $this->visitingInternships = new ArrayCollection();
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
        $roles = [];
        foreach ($this->userRoles as $roleEntity) {
            $roles[] = $roleEntity->getCode();
        }

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    /**
     * @param Role $role The role to add
     */
    public function addUserRole(Role $role): static
    {
        if (!$this->userRoles->contains($role)) {
            $this->userRoles->add($role);
        }

        return $this;
    }

    /**
     * @param Role $role The role to remove
     */
    public function removeUserRole(Role $role): static
    {
        $this->userRoles->removeElement($role);

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return trim(sprintf('%s %s', $this->firstName ?? '', $this->lastName ?? ''));
    }

    public function getTrigram(): string
    {
        $firstName = trim((string) $this->firstName);
        $lastName = trim((string) $this->lastName);

        if ($firstName === '' || $lastName === '') {
            return '';
        }

        $firstInitial = mb_substr($firstName, 0, 1);
        $lastPrefix = mb_substr($lastName, 0, 2);

        return mb_strtoupper($firstInitial.$lastPrefix);
    }

    /**
     * @return Collection<int, Internship>
     */
    public function getTrackingInternships(): Collection
    {
        return $this->trackingInternships;
    }

    public function addTrackingInternship(Internship $trackingInternship): static
    {
        if (!$this->trackingInternships->contains($trackingInternship)) {
            $this->trackingInternships->add($trackingInternship);
            $trackingInternship->setTrackingTeacher($this);
        }

        return $this;
    }

    public function removeTrackingInternship(Internship $trackingInternship): static
    {
        if ($this->trackingInternships->removeElement($trackingInternship)) {
            if ($trackingInternship->getTrackingTeacher() === $this) {
                $trackingInternship->setTrackingTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Internship>
     */
    public function getVisitingInternships(): Collection
    {
        return $this->visitingInternships;
    }

    public function addVisitingInternship(Internship $visitingInternship): static
    {
        if (!$this->visitingInternships->contains($visitingInternship)) {
            $this->visitingInternships->add($visitingInternship);
            $visitingInternship->setVisitingTeacher($this);
        }

        return $this;
    }

    public function removeVisitingInternship(Internship $visitingInternship): static
    {
        if ($this->visitingInternships->removeElement($visitingInternship)) {
            if ($visitingInternship->getVisitingTeacher() === $this) {
                $visitingInternship->setVisitingTeacher(null);
            }
        }

        return $this;
    }
}
