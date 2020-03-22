<?php

namespace App\Repository;

use App\Entity\MapOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MapOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method MapOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method MapOption[]    findAll()
 * @method MapOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MapOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MapOption::class);
    }

    // /**
    //  * @return MapOption[] Returns an array of MapOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MapOption
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
