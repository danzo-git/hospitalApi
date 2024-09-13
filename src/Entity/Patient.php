<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\PatientController;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity]
#[ApiResource(
    normalizationContext: ['groups' => ['patient:read']],
    denormalizationContext: ['groups' => ['patient:write']],
    operations: [
       new Get(),
       new Put(),
       new Patch(),
       new Delete(),
        new Post(
            name: 'createPatient', 
            uriTemplate: '/patient/create', 
            controller: PatientController::class
        )
    ]
)]
class Patient implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["patient:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $number = null;

    #[ORM\Column]
    #[Groups(["patient:read", "patient:write"])]
    private ?int $age = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $allergy = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $potentialIllness = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $file = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'patients')]
    #[ORM\JoinTable(name: 'patient_roles')]
    #[Groups(["patient:read" ])]
    private Collection $roles;

    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'idPatient', orphanRemoval: true)]
    #[Groups(["patient:read"])]
    private Collection $rdvs;

    public function __construct()
    {
        $this->rdvs = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->allergy;
    }

    public function setAllergy(?string $allergy): self
    {
        $this->allergy = $allergy;
        return $this;
    }

    public function getPotentialIllness(): ?string
    {
        return $this->potentialIllness;
    }

    public function setPotentialIllness(?string $potentialIllness): self
    {
        $this->potentialIllness = $potentialIllness;
        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return Collection<int, Rdv>
     */
    public function getRdvs(): Collection
    {
        return $this->rdvs;
    }

    public function addRdv(Rdv $rdv): self
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setIdPatient($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): self
    {
        if ($this->rdvs->removeElement($rdv)) {
            // Set the owning side to null (unless already changed)
            if ($rdv->getIdPatient() === $this) {
                $rdv->setIdPatient(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Returns the user roles.
     * @return array
     */
    public function getRoles(): array
    {
        $roles = $this->roles->map(function(Role $role) {
            return $role->getName();
        })->toArray();

        // Every user should have at least ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

 

    public function removeRole(Role $role): self
    {
        $this->roles->removeElement($role);
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // Clear sensitive data
    }
}
