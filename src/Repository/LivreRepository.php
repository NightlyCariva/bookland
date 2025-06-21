<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findgenreauteur(){
        $qb = $this->createQueryBuilder('l');
        $qb = $qb
             ->innerJoin('l.auteurs','a')
             ->innerJoin('l.genre','g')
            ->select('a.nom_prenom , g.nom')
            ->OrderBy('l.date_de_parution');

             $resultat=$qb->getQuery()->getResult();
             $auteurs =[];
             for($i=0 ; $i<count($resultat);$i++){
               $auteurs[$resultat[$i]['nom_prenom']]=[];
            
             }
             for($i=0 ; $i<count($resultat);$i++){
                $auteurs[$resultat[$i]['nom_prenom']][]=$resultat[$i]['nom'];  
              }
             dump($auteurs);
                dump($qb->getQuery()->getResult());
                return $auteurs;
    }
    public function findbygenre($genrenom){
        $qb = $this->createQueryBuilder('l');
        $qb = $qb
            ->select('l')
            ->innerJoin('l.genre', 'g')
            ->where('g.nom=:genrenom')
            ->setParameter('genrenom',$genrenom);

            dump($qb->getQuery()->getResult());
            return $qb->getQuery()->getResult();

    }
    public function findpagesmoyenne($genrenom){
        $qb = $this->createQueryBuilder('l');
        $qb = $qb
            ->select(' AVG(l.nbpages) as moyenne ')
            ->innerJoin('l.genre', 'g')
            ->where('g.nom=:genrenom')
            ->setParameter('genrenom',$genrenom);

            dump($qb->getQuery()->getResult());
            return $qb->getQuery()->getResult();
    }
    public function findbypartietitre($titre)
    {
        $qb = $this->createQueryBuilder('l');
        $qb = $qb
        ->where('l.titre LIKE :titre')
        ->setParameter('titre', "%$titre%");
       
       
        dump($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();

    }

    
    public function findAuteurNationaliteDiff(){

        $qb = $this->createQueryBuilder('l')

                ->Join('l.auteurs', 'a')
                ->groupBy('l.id')
                ->having('count(a.id) = count(DISTINCT a.nationalite)');
       
            return $qb->getQuery()->getResult();

    }
    
    public function listerSelonDate($date1, $date2){

        $qb = $this->createQueryBuilder('l')
                    ->select('l.titre', 'l.date_de_parution')
                    ->where( 'l.date_de_parution between :date1 and :date2') 
                    ->setParameter('date1', $date1->format('Y-m-d'))
                    ->setParameter('date2', $date2->format('Y-m-d'));

        dump($qb);

            
        return $qb->getQuery()->getResult();
}

    public function findDateNote($date1, $date2, $note1, $note2){

            $qb = $this->createQueryBuilder('l')
                        ->select('l.titre', 'l.note' , 'l.date_de_parution')
                        ->where( 'l.date_de_parution between :date1 and :date2')
                        ->andwhere('l.note between :note1 and :note2')  
                       
                        ->setParameter('date1', $date1->format('Y-m-d'))
                        ->setParameter('date2', $date2->format('Y-m-d'))
                        ->setParameter('note1', $note1)
                        ->setParameter('note2', $note2);
            dump($qb);

                
            return $qb->getQuery()->getResult();
    }

    public function listerParParite(){

        $qb = $this->createQueryBuilder('l')

                ->Join('l.auteurs', 'a')
                ->groupBy('l.id')
                ->having('count(a.id) = count(DISTINCT a.sexe)');
       
            return $qb->getQuery()->getResult();

    }
}
