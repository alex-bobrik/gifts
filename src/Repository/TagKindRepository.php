<?php

namespace App\Repository;

use App\Entity\TagKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TagKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagKind[]    findAll()
 * @method TagKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagKind::class);
    }

    // /**
    //  * @return TagKind[] Returns an array of TagKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TagKind
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
