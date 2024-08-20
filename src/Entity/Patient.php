<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
#[ORM\Table(name: '`patient`')]
#[ApiResource(
    normalizationContext: ['groups' => ['patient:read']],
    denormalizationContext: ['groups' => ['patient:write']]
)]
class Patient 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
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

    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'idPatient', orphanRemoval: true)]
    #[Groups(["patient:read"])]
    private Collection $rdvs;

    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'patient')]
    private Collection $roles;

    #[ORM\Column(length: 255)]
    #[Groups(["patient:read", "patient:write"])]
    private ?string $password = null;

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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->allergy;
    }

    public function setAllergy(?string $allergy): static
    {
        $this->allergy = $allergy;

        return $this;
    }

    public function getPotentialIllness(): ?string
    {
        return $this->potentialIllness;
    }

    public function setPotentialIllness(?string $potentialIllness): static
    {
        $this->potentialIllness = $potentialIllness;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
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

    public function addRdv(Rdv $rdv): static
    {
        if (!$this->rdvs->contains($rdv)) {
            $this->rdvs->add($rdv);
            $rdv->setIdPatient($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getIdPatient() === $this) {
                $rdv->setIdPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): static
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
            $role->setPatient($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getPatient() === $this) {
                $role->setPatient(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
