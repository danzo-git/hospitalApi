<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DoctorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: '`doctor`')]
#[ApiResource(
    normalizationContext: ['groups' => ['doctor:read']],
    denormalizationContext: ['groups' => ['doctor:write']]
)]
class Doctor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["doctor:read", "doctor:write"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["doctor:read","doctor:write"])]
    private ?string $Speciality = null;

    #[ORM\Column(length: 255)]
    #[Groups(["doctor:read","doctor:write"])]
    private ?string $grade = null;

    #[ORM\Column]
    #[Groups(["doctor:read","doctor:write"])]
    private ?int $yearOfExperience = null;

    #[ORM\ManyToMany(targetEntity: Hospital::class, mappedBy: 'idHospital')]
    
    private Collection $hospitals;

    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'doctor', orphanRemoval: true)]
    
    private Collection $rdvs;

    #[ORM\OneToMany(targetEntity: Disponibilite::class, mappedBy: 'medecin')]
    private Collection $disponibilites;

    #[ORM\OneToMany(targetEntity: Role::class, mappedBy: 'doctor')]
    private Collection $roles;

    public function __construct()
    {
        $this->hospitals = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
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

    public function getSpeciality(): ?string
    {
        return $this->Speciality;
    }

    public function setSpeciality(string $Speciality): static
    {
        $this->Speciality = $Speciality;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getYearOfExperience(): ?int
    {
        return $this->yearOfExperience;
    }

    public function setYearOfExperience(int $yearOfExperience): static
    {
        $this->yearOfExperience = $yearOfExperience;

        return $this;
    }

    /**
     * @return Collection<int, Hospital>
     */
    public function getHospitals(): Collection
    {
        return $this->hospitals;
    }

    public function addHospital(Hospital $hospital): static
    {
        if (!$this->hospitals->contains($hospital)) {
            $this->hospitals->add($hospital);
            $hospital->addIdHospital($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): static
    {
        if ($this->hospitals->removeElement($hospital)) {
            $hospital->removeIdHospital($this);
        }

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
            $rdv->setDoctor($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getDoctor() === $this) {
                $rdv->setDoctor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Disponibilite>
     */
    public function getDisponibilites(): Collection
    {
        return $this->disponibilites;
    }

    public function addDisponibilite(Disponibilite $disponibilite): static
    {
        if (!$this->disponibilites->contains($disponibilite)) {
            $this->disponibilites->add($disponibilite);
            $disponibilite->setMedecin($this);
        }

        return $this;
    }

    public function removeDisponibilite(Disponibilite $disponibilite): static
    {
        if ($this->disponibilites->removeElement($disponibilite)) {
            // set the owning side to null (unless already changed)
            if ($disponibilite->getMedecin() === $this) {
                $disponibilite->setMedecin(null);
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
            $role->setDoctor($this);
        }

        return $this;
    }

    public function removeRole(Role $role): static
    {
        if ($this->roles->removeElement($role)) {
            // set the owning side to null (unless already changed)
            if ($role->getDoctor() === $this) {
                $role->setDoctor(null);
            }
        }

        return $this;
    }
}
