<?php 

namespace App\Service;
use App\Entity\Patient;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Role;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientHandler
{

    public function __construct( private UserPasswordHasherInterface $passwordHasher)
    {
        
    }
    
    public function handle(Patient $patient, EntityManagerInterface $entityManager): Patient
    {

        $patient->setPassword($this->passwordHasher->hashPassword($patient, $patient->getPassword()));
        //recuperer ou creer un nouveuveau role
        $role = $entityManager->getRepository(Role::class)->findOneBy(['name' => 'ROLE_USER']);
        if(!$role){
            $role = new Role();
            $role->setName('ROLE_USER');
            $entityManager->persist($role);
        }
        $patient->addRole($role);
        // Persist des deux côtés de la relation
        $entityManager->persist($patient);
        // Sauvegarde dans la base de données
        $entityManager->flush();
        return $patient;
    }

    
}