<?php



// src/Security/AuthenticationSuccessHandler.php
namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Patient;
class AuthenticationSuccessHandler
{
    private $jwtManager;

    public function __construct(JWTManager $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // // Assume $token->getUser() returns an instance of the Patient entity
        // $user = $token->getPatient();

        // // Define custom payload data
        // $payload = [
        //     'email' => $user->getEmail(),
        //     'roles' => $user->getRoles(),
        //     // Add more custom claims here if needed
        // ];

        // // Generate JWT token with custom payload
        // $jwt = $this->jwtManager->create($user);

        // return new JsonResponse(['token' => $jwt, 'user' => $payload]);
    }
}