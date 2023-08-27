<?php

namespace App\Repository;

use App\Entity\MRP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    /**
     * @return MRP[] Returns an array of MRP objects
     */
    public function findByRoverName(string $roverName, int $offset): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('App\Entity\Rover', 'r', Join::WITH, 'r.id = m.rover_id')
            ->andWhere('r.name = :roverName')
            ->setParameter('roverName', $roverName)
            ->orderBy('m.earth_date', 'DESC')
            ->setMaxResults(50)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function findByDateRange(string $dateFrom, string $dateTo, int $offset): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.earth_date BETWEEN :dateFrom AND :dateTo')
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->orderBy('m.earth_date', 'DESC')
            ->setMaxResults(50)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function getLastSol(string $roverName): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.sol')
            ->leftJoin('App\Entity\Rover', 'r', Join::WITH, 'r.id = m.rover_id')
            ->andWhere('r.name = :roverName')
            ->setParameter('roverName', $roverName)
            ->orderBy('m.sol', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function findByRoverNameAndSol(string $roverName, int $sol): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('App\Entity\Rover', 'r', Join::WITH, 'r.id = m.rover_id')
            ->andWhere('r.name = :roverName')
            ->andWhere('m.sol = :sol')
            ->setParameter('roverName', $roverName)
            ->setParameter('sol', $sol)
            ->orderBy('m.sol', 'DESC')
            ->getQuery()
            ->getResult();
    }

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
