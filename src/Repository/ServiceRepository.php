<?php

namespace App\Repository;

use App\Entity\Service;
use App\Entity\Hospital;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    private $serializer;
    public function __construct(ManagerRegistry $registry,SerializerInterface $serializer)
    {
        parent::__construct($registry, Service::class);
        $this->serializer = $serializer;
    }

    //    /**
    //     * @return Service[] Returns an array of Service objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Service
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function addServiceRepo($serviceData)
    {
        $entityManager = $this->getEntityManager();
        $service = new Service();
        
        if ($serviceData['name'] !== null) {
            $service->setName($serviceData['name']);
        }
        if ($serviceData['status'] !== null) {
            $service->setStatus($serviceData['status']);
        }
        $hospitalIds = explode(',', $serviceData['hopital_ids']);
        
        foreach ($hospitalIds as $hospitalId) {
            $hospital = $entityManager->getRepository(Hospital::class)->find($hospitalId);
            if ($hospital !== null) {
                $service->setHopital($hospital);
            }
        }
        
        $entityManager->persist($service);
        $entityManager->flush();
        
        return $service;
    }

}
