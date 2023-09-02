<?php

namespace App\Repository;

use App\Entity\Rover;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rover>
 *
 * @method Rover|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rover|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rover[]    findAll()
 * @method Rover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rover::class);
    }


    /**
     * @return Rover[] Returns an array of Rover objects
     */
    public function getAllRoverNames(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.name')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getRoverIdByName(string $roverName): int
    {
        $data = $this->createQueryBuilder('r')
            ->select('r.id')
            ->andWhere('r.name = :roverName')
            ->setParameter('roverName', $roverName)
            ->getQuery()
            ->getResult();
        return $data[0]['id'];
    }

    public function getMaxSolByName(string $roverName): int
    {
        $data = $this->createQueryBuilder('r')
            ->select('r.max_sol')
            ->andWhere('r.name = :roverName')
            ->setParameter('roverName', $roverName)
            ->getQuery()
            ->getResult();
        return $data[0]['max_sol'];
    }

//    public function findOneBySomeField($value): ?Rover
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
