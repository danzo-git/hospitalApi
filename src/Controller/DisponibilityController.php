<?php

namespace App\Controller;
use App\Service\DisponibiliteGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DisponibiliteRepository;
class DisponibilityController extends AbstractController
{

    public function __construct(private DisponibiliteRepository $disponibiliteRepository, private DoctorRepository $DoctorRepository){}
   
    // #[Route('api/disponibilities/medecin/{id}', name: 'app_disponibility')]
    // public function disponibility($id): Response
    // {
    //     return $this->json($this->disponibiliteRepository->findDisponibilitesByMedecin($id));
    // }


    #[Route('api/medecins/{id}/creneaux/{date}', name: 'get_medecin_creneaux')]
    public function getCreneaux(int $id, string $date, DisponibiliteGenerator $generator): JsonResponse
{
    $medecin = $this->DoctorRepository->find($id);
    if (!$medecin) {
        return new JsonResponse(['error' => 'Médecin introuvable'], 404);
    }

    $dateObject = new \DateTime($date);
    $creneaux = $generator->generateSlots($medecin, $dateObject);

    return new JsonResponse($creneaux);
}
}
