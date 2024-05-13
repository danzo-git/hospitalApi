<?php

namespace App\Controller;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ServiceController extends AbstractController
{
    private  $serviceRepo;
    public function __construct(ServiceRepository $serviceRepo,SerializerInterface $serializer){
        $this->serviceRepo=$serviceRepo;
        $this->serializer = $serializer;
    }
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }

    #[Route('/api/add/service', name: 'app_service')]
    public function addService(Request $request, ServiceRepository $serviceRepo, SerializerInterface $serializer): Response
    {
        $serviceData = [
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'hopital_ids' => $request->get('hopital_ids')
        ];
    
        if ($serviceData != null) {
            $service = $serviceRepo->addServiceRepo($serviceData);
        }
    
        $serializedService = $serializer->serialize($service, 'json', ['groups' => 'exclude_relationships']);
    
        return new Response($serializedService, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }

}
