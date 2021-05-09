<?php

namespace App\Repository;

use App\Entity\Detailstache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Detailstache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detailstache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detailstache[]    findAll()
 * @method Detailstache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailstacheRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Detailstache::class);
    }

    // /**
    //  * @return Detailstache[] Returns an array of Detailstache objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Detailstache
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
