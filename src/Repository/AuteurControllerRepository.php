<?php

namespace App\Repository;

use App\Entity\AuteurController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuteurController|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuteurController|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuteurController[]    findAll()
 * @method AuteurController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuteurController::class);
    }

    // /**
    //  * @return AuteurController[] Returns an array of AuteurController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AuteurController
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
}
