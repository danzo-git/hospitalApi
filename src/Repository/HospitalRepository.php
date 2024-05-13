<?php

namespace App\Repository;

use App\Entity\Hospital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hospital>
 *
 * @method Hospital|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hospital|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hospital[]    findAll()
 * @method Hospital[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HospitalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hospital::class);
    }

    //    /**
    //     * @return Hospital[] Returns an array of Hospital objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Hospital
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findHospital(){
        return  $this->createQueryBuilder('t')->getQuery()->getResult();   
      }

      public function AddHospitalRepo($hospitalData   )
      {
          $entityManager = $this->getEntityManager();
          $hospital = new Hospital();
          
          if ($hospitalData['name'] !== null) {
            $hospital->setName($hospitalData['name']);
          }
          if ($hospitalData['position'] !== null) {
            $hospital->setPosition($hospitalData['position']);
          }

          // dd($hospitalData['doctor_ids']);
          /*foreach ($hospitalData['doctor_ids'] as $doctorId) {
            $doctor=$entityManager->getRepository(Doctor::class)->find($doctorId);
            if($doctor){
              $hospital->addDoctor($doctor);
            }
          }*/
         
          $entityManager->persist($hospital);
          $entityManager->flush();
      
          return $hospital;
      }
      
}
