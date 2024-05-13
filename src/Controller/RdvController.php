<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RdvRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{
    Patient,
    Service,
    Doctor,
    Rdv
};
class RdvController extends AbstractController
{
    private RdvRepository $rdvRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(RdvRepository $rdvRepository, EntityManagerInterface $entityManager){
        $this->rdvRepository=$rdvRepository;
        $this->entityManager=$entityManager;
    }
    #[Route('/rdv', name: 'app_rdv')]
    public function index(): Response
    {
        return $this->render('rdv/index.html.twig', [
            'controller_name' => 'RdvController',
        ]);
    }

    /**
     * Insertion des données dans la table rdv
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/createrdv', name: 'app_create_rdv')]
    public function CreateRdv(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $rdv = new Rdv();
        $patient = $entityManager->getRepository(Patient::class)->find($request->get('idPatient'));
        $service = $entityManager->getRepository(Service::class)->find($request->get('service'));
        $doctor = $entityManager->getRepository(Doctor::class)->find($request->get('doctor'));
        
        $rdv->setIdPatient($patient)->setService($service)->setDoctor($doctor);

        $entityManager->persist($rdv);
        $entityManager->flush();

        return $this->json($rdv, 201, [], [
            'groups' => ['rdv:create']
        ]);

}
}