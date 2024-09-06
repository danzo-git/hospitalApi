<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RdvRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RdvRepository::class)]
#[ORM\Table(name: '`rdv`')]
#[ApiResource(
    normalizationContext: ['groups' => ['rdv:read']],
    denormalizationContext: ['groups' => ['rdv:write']],
)]
class Rdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(["rdv:read", "rdv:write","patient:read"])]
    private ?Patient $idPatient = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(["rdv:read", "rdv:write","service:read"])]
    private ?Service $service = null;

    #[ORM\ManyToOne(inversedBy: 'rdvs')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(["rdv:read", "rdv:write","doctor:read"])]
    private ?Doctor $doctor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPatient(): ?Patient
    {
        return $this->idPatient;
    }

    public function setIdPatient(?Patient $idPatient): static
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): static
    {
        $this->service = $service;

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

    
}
