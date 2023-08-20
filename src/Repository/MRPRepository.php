<?php

namespace App\Repository;

use App\Entity\MRP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MRP>
 *
 * @method MRP|null find($id, $lockMode = null, $lockVersion = null)
 * @method MRP|null findOneBy(array $criteria, array $orderBy = null)
 * @method MRP[]    findAll()
 * @method MRP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MRPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MRP::class);
    }

//    /**
//     * @return MRP[] Returns an array of MRP objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MRP
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
