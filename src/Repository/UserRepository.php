<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tache|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tache|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tache[]    findAll()
 * @method Tache[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findAllroles($roles): array
{
    
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM fos_user p
        WHERE p.roles LIKE :roles
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['roles' => $roles]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
}



public function findAllname($username): array
{
    
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM fos_user p
        WHERE p.username LIKE :username
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
}

public function getNb() {
 
    return $this->createQueryBuilder('l')

                    ->select('COUNT(l)')

                    ->getQuery()

                    ->getSingleScalarResult();

}

    // /**
    //  * @return Tache[] Returns an array of Tache objects
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
    public function findOneBySomeField($value): ?Tache
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
