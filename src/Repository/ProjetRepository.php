<?php

namespace App\Repository;

use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    public function getNb() {
 
        return $this->createQueryBuilder('l')
 
                        ->select('COUNT(l)')
 
                        ->getQuery()
 
                        ->getSingleScalarResult();
 
    }

    public function countprojects()
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


    // /**
    //  * @return Projet[] Returns an array of Projet objects
    //  */

    /*
/**
     

    
    public function findByRole($role) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
                ->from($this->user, 'u')
                ->where('u.roles LIKE :Role_CHEF')
                ->setParameter('roles', '%"' . $role . '"%');
        return $qb->getQuery()->getResult();
    }
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
