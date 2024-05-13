<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Request;
class PatientController extends AbstractController
{

    private  $patientRepo;
    public function __construct(PatientRepository $patientRepo){
        $this->patientRepo=$patientRepo;
    }
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }


    #[Route('/api/addPatient', name: 'app_patient')]
    public function addPatient(Request $request,PatientRepository $patientRepo)
    {
       
         $patientData= [
          'name'=>$request->get('name'),
            'first_name'=>$request->get('first_name'),
            'email'=>$request->get('email'),
            'number'=>$request->get('number'),
            'age'=>$request->get('age'),
            'allergy'=>$request->get('allergy'),
            'potential_illness'=>$request->get('potential_illness'),
            'file'=>$request->get('file'),
        ];
        dd($patientData);
       
        if($patientData!=null){
            $newPatient=$patientRepo->AddPatientRepo($patientData);
        }
        return $this->Json($newPatient);
    }
}
