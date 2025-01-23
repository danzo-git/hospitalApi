<?php

namespace App\Repository;

use App\Entity\Doctor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Hospital;
/**
 * @extends ServiceEntityRepository<Doctor>
 *
 * @method Doctor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doctor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doctor[]    findAll()
 * @method Doctor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doctor::class);
    }



    public function addDoctorRepo($DoctorData){
      $entityManager = $this->getEntityManager();
      $doctor = new Doctor();
      $doctor->setName($DoctorData['name']);
      $doctor->setSpeciality($DoctorData['speciality']);
      $doctor->setGrade($DoctorData['grade']);
      $doctor->setYearOfExperience(intval($DoctorData['year_of_experience']));
      
      // Vérifier que $DoctorData['hospital_ids'] est un tableau
     $DoctorTable=explode(',',$DoctorData['hospital_ids']);
          foreach ($DoctorTable as $hospitalId) {
              $hospital = $entityManager->getRepository(Hospital::class)->find($hospitalId);
              if ($hospital) {
                  $doctor->addHospital($hospital);
              }
          }
   
      $entityManager->persist($doctor);
      $entityManager->flush();
  }
  
  
  public function getDoctorsBySpecialityRepo($speciality){
      return $this->createQueryBuilder('d')
          ->andWhere('d.Speciality = :speciality')
          ->setParameter('speciality', $speciality)
          ->getQuery()
          ->getResult();
  }


  /**
     * Trouve les médecins travaillant dans un service et un hôpital spécifiques
     */
    public function findDoctorsByServiceAndHospitalRepo(int $serviceId, int $hospitalId): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.services', 's')
            ->join('s.hopital', 'h')
            ->where('s.id = :serviceId')
            ->andWhere('h.id = :hospitalId')
            ->setParameter('serviceId', $serviceId)
            ->setParameter('hospitalId', $hospitalId)
            ->getQuery()
            ->getResult();
    }
}
