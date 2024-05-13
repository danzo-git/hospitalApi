<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DoctorRepository;
use App\Entity\Doctor;
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

}
