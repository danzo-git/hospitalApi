<?php
 
namespace App\EventListener;
 
// use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Patient;

class PatientPasswordHasherListener
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(\Doctrine\Persistence\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Patient) {
            return;
        }

        $this->hashPassword($entity);
    }

    public function preUpdate(\Doctrine\Persistence\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Patient) {
            return;
        }

        $this->hashPassword($entity);
    }

    private function hashPassword(Patient $patient)
    {
        if ($patient->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($patient, $patient->getPassword());
            $patient->setPassword($hashedPassword);
        }
    }
}
