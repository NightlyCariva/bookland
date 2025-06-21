<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    // /**
    //  * @return Genre[] Returns an array of Genre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Genre
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findgenreauteur($nomauteur){
        $qb = $this->createQueryBuilder('g');
        $qb = $qb
            ->innerJoin('g.livres', 'l')
            ->innerJoin('l.auteurs','a')
            ->where('a.nomPrenom = :nomauteur')
            ->setParameter('nomauteur',$nomauteur)
            ->having('COUNT(g.id) >= 2')
            ->groupBy('g');
            
            
            dump($qb->getQuery()->getResult());
            return $qb->getQuery()->getResult();

    }
    public function findAuteurGneres1Livre($id){
        $qb = $this->createQueryBuilder('g');
        $qb = $qb
        ->innerJoin('g.livres', 'l')
        ->innerJoin('l.auteurs','a')
        ->where('a.id = :id')
        ->having('COUNT(g.id) >= 1')
        ->groupBy('g')
        ->setParameter('id',$id);
        dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }
    public function listerGenreParAuteur(){

        $qb = $this->createQueryBuilder('g')

                ->innerJoin('g.livres', 'l')
                ->innerJoin('l.auteurs','a')
                //->groupBy('g.nom','l.titre')
                ->select('g.nom','a.nom_prenom','l.titre');
        return $qb->getQuery()->getResult();

    }

    public function afficherNbPages($genre){

        $qb = $this->createQueryBuilder('g')

            ->Join('g.livres', 'l')
            ->select('SUM(l.nbpages) as somme', 'g.nom')
            ->where('g.nom = :genrenom')
            ->setParameter('genrenom', $genre);
            

        return $qb->getQuery()->getResult();

    }
}
