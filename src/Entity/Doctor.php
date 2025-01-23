<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DoctorRepository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;	
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Controller\DoctorController;
use App\Controller\FindDoctorByServiceAndHospitalController;



#[ORM\Entity(repositoryClass: DoctorRepository::class)]
#[ORM\Table(name: '`doctor`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
        new Get(
            uriTemplate: '/doctors/{speciality}',
            controller: DoctorController::class,
            openapiContext: [
                'summary' => 'Récupère la liste des docteurs pour une spécialité donnée',
                'parameters' => [
                    [
                        'name' => 'speciality',
                        'in' => 'path',
                        'required' => true,
                        'description' => 'La spécialité des docteurs à récupérer',
                        'schema' => ['type' => 'string', 'example' => 'cardiologie']
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Liste des docteurs',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'id' => ['type' => 'integer', 'example' => 1],
                                            'name' => ['type' => 'string', 'example' => 'Dr. Dupont'],
                                            'speciality' => ['type' => 'string', 'example' => 'cardiologie'],
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '404' => [
                        'description' => 'Aucun docteur trouvé pour cette spécialité'
                    ]
                ]
            ]
        ),
        new GetCollection(
            uriTemplate: '/doctors_by_service_and_hospital',
            controller: FindDoctorByServiceAndHospitalController::class,
            openapiContext: [
                'summary' => 'Récupère les docteurs pour un service et un hôpital donnés',
                'parameters' => [
                    [
                        'name' => 'service',
                        'in' => 'query',
                        'required' => true,
                        'description' => 'ID du service',
                        'schema' => ['type' => 'integer']
                    ],
                    [
                        'name' => 'hospital',
                        'in' => 'query',
                        'required' => true,
                        'description' => 'ID de lhôpital',
                        'schema' => ['type' => 'integer']
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Liste des docteurs filtrée',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'array',
                                    'items' => [
                                        '$ref' => '#/components/schemas/Doctor'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '404' => ['description' => 'Aucun docteur trouvé'],
                ]
            ]
        )
    ],
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

   
    #[Groups(["doctor:read","doctor:write"])]
    #[ORM\ManyToMany(targetEntity: Service::class, inversedBy: 'doctors')]
    #[ORM\JoinTable(name: 'doctor_service')]
    private $services;

  private $doctorRepository;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $dateDebut = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $heureDebutMatin = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $heureDebutApresMidi = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $heureFinApresMidi = null;

  #[ORM\Column(nullable: true)]
  private ?array $joursTravailles = [];

  #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
  private ?\DateTimeInterface $heureFinMatin = null;
    public function __construct(
        DoctorRepository $doctorRepository
    )
    {
        $this->hospitals = new ArrayCollection();
        $this->rdvs = new ArrayCollection();
        $this->disponibilites = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->doctorRepository = $doctorRepository;
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
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    // Méthodes d'ajout et de suppression
    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->addDoctor($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeDoctor($this);
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getHeureDebutMatin(): ?\DateTimeInterface
    {
        return $this->heureDebutMatin;
    }

    public function setHeureDebutMatin(?\DateTimeInterface $heureDebutMatin): static
    {
        $this->heureDebutMatin = $heureDebutMatin;

        return $this;
    }

    public function getHeureDebutApresMidi(): ?\DateTimeInterface
    {
        return $this->heureDebutApresMidi;
    }

    public function setHeureDebutApresMidi(?\DateTimeInterface $heureDebutApresMidi): static
    {
        $this->heureDebutApresMidi = $heureDebutApresMidi;

        return $this;
    }

    public function getHeureFinApresMidi(): ?\DateTimeInterface
    {
        return $this->heureFinApresMidi;
    }

    public function setHeureFinApresMidi(?\DateTimeInterface $heureFinApresMidi): static
    {
        $this->heureFinApresMidi = $heureFinApresMidi;

        return $this;
    }

    public function getJoursTravailles(): ?array
    {
        return $this->joursTravailles;
    }

    public function setJoursTravailles(?array $joursTravailles): static
    {
        $this->joursTravailles = $joursTravailles;

        return $this;
    }

    public function getHeureFinMatin(): ?\DateTimeInterface
    {
        return $this->heureFinMatin;
    }

    public function setHeureFinMatin(?\DateTimeInterface $heureFinMatin): static
    {
        $this->heureFinMatin = $heureFinMatin;

        return $this;
    }

 
}
