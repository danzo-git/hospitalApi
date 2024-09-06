<?php

namespace App\Controller;
use App\DTO\HospitalDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\HospitalRepository;
use Symfony\Component\HttpFoundation\Request;


class HospitalController extends AbstractController
{
    private $hospitalrepo;
    public function __construct(HospitalRepository $hospitalrepo){
        $this->hospitalrepo = $hospitalrepo;
    }
  
    
  /**
     * Display hospitals from the database.
     *
     * @param HospitalRepository $hospitalrepo The hospital repository
     * @return Response
     */
    #[Route('/api/hospitals', name: 'app_hospitals')]
    public function index(HospitalRepository $hospitalrepo): Response
    {
        $hospitals=$this->hospitalrepo->findAll();
        $hospitalDTOs = [];

        foreach ($hospitals as $hospital) {
            $hospitalDTOs[] = new   HospitalDTO($hospital->getName(), $hospital->getPosition());
        }
        
        return $this->json($hospitalDTOs);
    
    }




    /**
     * add hospital
     */

    #[Route('/api/addHospital', name: 'app_hospital')]
    public function addHospital(Request $request,HospitalRepository $hospitalrepo)
    
    {
        $name = $request->get('name');
        $position = $request->get('position');
        $hospitalData=[
        'name' =>$name,
        'position'=>$position,
        // 'doctor_ids'=>$request->get('doctor_ids')
        ];
        if($hospitalData!=null){
            $newHospital=$hospitalrepo->AddHospitalRepo($hospitalData);
        }
       
       
        return $this->Json($newHospital);
    }

    
}
