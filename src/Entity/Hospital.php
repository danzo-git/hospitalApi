<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\ManyToMany(targetEntity: Doctor::class, inversedBy: 'hospitals')]
    private Collection $idHospital;

    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'hopital', orphanRemoval: true)]
    /**
     * @Groups({"exclude_relationships"})
     */
    private Collection $services;

    public function __construct()
    {
        $this->idHospital = new ArrayCollection();
        $this->services = new ArrayCollection();
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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Doctor>
     */
    public function getIdHospital(): Collection
    {
        return $this->idHospital;
    }

    public function addIdHospital(Doctor $idHospital): static
    {
        if (!$this->idHospital->contains($idHospital)) {
            $this->idHospital->add($idHospital);
        }

        return $this;
    }

    public function removeIdHospital(Doctor $idHospital): static
    {
        $this->idHospital->removeElement($idHospital);

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setHopital($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getHopital() === $this) {
                $service->setHopital(null);
            }
        }

        return $this;
    }
}
