<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\Table(name: '`service`')]
#[ApiResource(
    normalizationContext: ['groups' => ['service:read']],
    denormalizationContext: ['groups' => ['service:write']]
)]
#[ApiFilter(SearchFilter::class, properties: ['hospital' => 'exact'])]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["service:read","service:write"])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(["service:read", "service:write"])]
    private ?bool $status = null;

    #[ORM\OneToMany(targetEntity: Rdv::class, mappedBy: 'service', orphanRemoval: true)]
    #[Groups(["service:read"])]

    private Collection $rdvs;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["service:read", "service:write","hopital:read"])]
  
    private ?Hospital $hopital = null;
    #[Groups(["service:read", "service:write"])]
    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;
    #[Groups(["service:read", "service:write"])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;
    #[Groups(["service:read", "service:write"])]
    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctor $doctor = null;
    #[Groups(["service:read", "service:write"])]
    #[ORM\ManyToMany(targetEntity: Doctor::class, mappedBy: 'services')]
    private $doctors;
    public function __construct()
    {
        $this->rdvs = new ArrayCollection();
        $this->doctors = new ArrayCollection();
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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

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
            $rdv->setService($this);
        }

        return $this;
    }

    public function removeRdv(Rdv $rdv): static
    {
        if ($this->rdvs->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getService() === $this) {
                $rdv->setService(null);
            }
        }

        return $this;
    }

    public function getHopital(): ?Hospital
    {
        return $this->hopital;
    }

    public function setHopital(?Hospital $hopital): static
    {
        $this->hopital = $hopital;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }


    public function addDoctor(Doctor $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
            $doctor->addService($this);
        }

        return $this;
    }

    public function removeDoctor(Doctor $doctor): self
    {
        if ($this->doctors->removeElement($doctor)) {
            $doctor->removeService($this);
        }

        return $this;
    }
    
    
}
