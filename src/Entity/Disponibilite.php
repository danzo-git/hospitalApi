<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DisponibiliteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['disponibilite:read']],
    denormalizationContext: ['groups' => ['disponibilite:write']],
)]
#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Groups(["disponibilite:read", "disponibilite:write"])]
    private ?int $jour_semaine = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["disponibilite:read", "disponibilite:write"])]
    private ?\DateTimeInterface $heure_debut = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["disponibilite:read", "disponibilite:write"])]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\ManyToOne(inversedBy: 'disponibilites')]
    private ?Doctor $medecin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourSemaine(): ?int
    {
        return $this->jour_semaine;
    }

    public function setJourSemaine(string $jour_semaine): static
    {
        $this->jour_semaine = $jour_semaine;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): static
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getMedecin(): ?Doctor
    {
        return $this->medecin;
    }

    public function setMedecin(?Doctor $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }
}
