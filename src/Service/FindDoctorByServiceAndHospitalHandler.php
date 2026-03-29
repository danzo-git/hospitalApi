<?php
namespace App\Service;

use App\Repository\DoctorRepository;
class FindDoctorByServiceAndHospitalHandler
{
    private $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function Handle(int $serviceId, int $hospitalId): array
    {
        return $this->doctorRepository->findDoctorsByServiceAndHospitalRepo($serviceId, $hospitalId);
    }
}

