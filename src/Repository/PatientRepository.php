<?php

namespace App\Repository;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Patient;

/**
 * @extends ServiceEntityRepository<Patient>
 *
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    //    /**
    //     * @return Patient[] Returns an array of Patient objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Patient
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function addPatientRepo($patientData){

        $entityManager = $this->getEntityManager();
        $patient = new Patient();

    
        $patient->setName($patientData['name']);
        $patient->setFirstName($patientData['first_name']);
        $patient->setEmail($patientData['email']);
        $patient->setNumber(intval($patientData['number']));
        $patient->setAge($patientData['age']);
        $patient->setAllergy($patientData['allergy']);
        $patient->setPotentialIllness($patientData['potential_illness']);
        $patient->setFile($patientData['file']);
      
        $entityManager->persist($patient);
        $entityManager->flush();
    }
}
