<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DoctorRepository;
use App\Entity\Doctor;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
class DoctorController extends AbstractController
{
    private $doctorRepo;
    public function __construct(DoctorRepository $doctorRepo){
        $this->doctorRepo=$doctorRepo;
    }

    #[Route('/doctor', name: 'app_doctor')]
    public function index(): Response
    {
        return $this->render('doctor/index.html.twig', [
            'controller_name' => 'DoctorController',
        ]);
    }
    /**
     * Adds a new doctor to the database.
     *
     * @param Request $request The HTTP request object.
     * @param DoctorRepository $doctorRepo The repository for managing doctors.
     * @return Response The JSON response containing the added doctor.
     */

    #[Route('/api/addoctor', name: 'app_doctor')]
    public function addDoctor(Request  $request,DoctorRepository $doctorRepo ): Response
    {
      
      $DoctorData=[
        'name'=>$request->get('name'),
        'speciality'=>$request->get('speciality'),
        'grade'=>$request->get('grade'),
        'year_of_experience'=>$request->get('YearOfExperience'),
        'hospital_ids'=>$request->get('hospital_ids')
      ];
    //   dd($DoctorData[ 'YearOfExperience']);
      if( $DoctorData!=null){
        $doctor=$doctorRepo->addDoctorRepo($DoctorData);
      }
      return $this->json($doctor);
    }

    #[Route('/api/doctors/{speciality}', name: 'app_doctor')]
    public function getDoctorsBySpeciality($speciality, DoctorRepository $doctorRepo): JsonResponse
    {
         
      $doctors = $doctorRepo->getDoctorsBySpecialityRepo($speciality);
        
      if (empty($doctors)) {
          return $this->json(['message' => 'Aucun docteur trouvé pour cette spécialité.'], Response::HTTP_NOT_FOUND);
      }

      return $this->json($doctors);
    }


    public function findDoctorsByServiceAndHospital(int $serviceId, int $hospitalId): array
    {
        return $this->doctorRepo->findDoctorsByServiceAndHospitalRepo($serviceId, $hospitalId);
    }

}
