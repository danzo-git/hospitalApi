<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Patient;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Service\PatientHandler;

#[AsController]
class PatientController extends AbstractController
{

   
    public function __construct( private PatientHandler $patientHandler, private EntityManagerInterface $entityManager){
       
    }
    
    public function __invoke(Patient $patient): Patient
    {

        $this->patientHandler->handle($patient, $this->entityManager);

        sprintf('%s %s', $patient->getName(), $patient->getFirstName());
        return $patient;
    }


    



 



}
