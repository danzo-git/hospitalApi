<?php

namespace App\Controller;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FindDoctorByServiceAndHospitalHandler;
class FindDoctorByServiceAndHospitalController extends AbstractController
{
    

    public function __construct(private FindDoctorByServiceAndHospitalHandler $handler)
    {
       
    }

    public function __invoke(Request $request) 
    {
        $service = (int) $request->query->get('service');
        $hospital = (int) $request->query->get('hospital');

        $doctors = $this->handler->Handle($service, $hospital);
        
        if (empty($doctors)) {
            return $this->json(
                ['message' => 'Aucun docteur trouvé pour ce service et cet hôpital'],
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->json($doctors);
    }
}
