<?php

namespace App\Repository;

use App\Entity\APOD;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<APOD>
 *
 * @method APOD|null find($id, $lockMode = null, $lockVersion = null)
 * @method APOD|null findOneBy(array $criteria, array $orderBy = null)
 * @method APOD[]    findAll()
 * @method APOD[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class APODRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, APOD::class);
    }


//    /**
//     * @return APOD[] Returns an array of APOD objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?APOD
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
