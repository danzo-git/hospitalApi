<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Patient;
use Symfony\Bundle\SecurityBundle\Security;
#[AsController]
class MeController
{
    private $security;
    private $patient;
    public function __construct(Security $security ,Patient $patient)
    {
        $this->security = $security;
        $this->patient = $patient;
    }

    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function __invoke()
    {
        $user = $this->security->getUser();
        $pat=$this->patient->getName();
dd($pat);
        return new JsonResponse([
           'user'=>$user
            // Ajoutez d'autres informations utilisateur si nécessaire
        ]);
    }
}
