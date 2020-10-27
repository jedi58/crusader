<?php

namespace App\Repository;

use App\Entity\BattlefieldRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BattlefieldRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method BattlefieldRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method BattlefieldRole[]    findAll()
 * @method BattlefieldRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BattlefieldRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BattlefieldRole::class);
    }

    // /**
    //  * @return BattlefieldRole[] Returns an array of BattlefieldRole objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BattlefieldRole
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
