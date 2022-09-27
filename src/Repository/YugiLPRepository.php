<?php

namespace App\Repository;

use App\Entity\YugiLP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YugiLP|null find($id, $lockMode = null, $lockVersion = null)
 * @method YugiLP|null findOneBy(array $criteria, array $orderBy = null)
 * @method YugiLP[]    findAll()
 * @method YugiLP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YugiLPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YugiLP::class);
    }

    // /**
    //  * @return YugiLP[] Returns an array of YugiLP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?YugiLP
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
