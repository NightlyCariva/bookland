<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\AuteurRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {   
        
    
        return $this->render('home.html.twig', [
             'controller_name' => 'HomeController'
        ]);
    }
    

    /**
     * @Route("/action13", name="action13")
     */

    public function ListerParDate(Request $request, LivreRepository $repo){

        
        $form = $this ->createFormBuilder()
                    ->add('date1',DateType::class,[
                        'widget' => 'single_text'
                    ])
                    ->add('date2',DateType::class,[
                        'widget' => 'single_text'
                    ])
                    ->add('Valider',SubmitType::class)
                    ->getForm();


        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {   
            $data = $form->getData();
            $date1= new \DateTime;
            $date2= new \DateTime;
            $date1=$data['date1'];
            $date2=$data['date2'];
            return $this->render ('resultat_lister_date.html.twig',[
                'livres' => $repo->listerSelonDate($date1, $date2)
            ]);
        }                

        return $this->render('form_lister_date.html.twig',[
            'form' => $form->createview(),
        ]);


    }

    /**
     * @Route("/action14", name="action14")
     */

    public function ListerParNationalite(LivreRepository $repo){

       
        return $this->render('lister.html.twig', [
            'livres' => $repo->findAuteurNationaliteDiff()
        ]);
    }

    /**
     * @Route("/action15", name="action15")
     */

    public function ListerDate(Request $request, LivreRepository $repo){

        
        $form = $this ->createFormBuilder()
                    ->add('date1',DateType::class,[
                        'widget' => 'single_text'
                    ])
                    ->add('date2',DateType::class,[
                        'widget' => 'single_text'
                    ])
                    ->add('note1',TextType::class)
                    ->add('note2',TextType::class)
                    ->add('Valider',SubmitType::class)
                    ->getForm();


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   
            $data = $form->getData();
            $date1= new \DateTime;
            $date2= new \DateTime;
            $date1=$data['date1'];
            $date2=$data['date2'];
            $note1=$data['note1'];
            $note2=$data['note2'];
            return $this->render ('resultat_date_note.html.twig',[
                'livres' => $repo->findDateNote($date1, $date2, $note1, $note2)
            ]);
        }                

        return $this->render('lister_date_note.html.twig',[
            'form' => $form->createview(),
        ]);


    }

    /**
     * @Route("/action16", name="action16")
     */

    public function lister3livres(AuteurRepository $repo){

        return $this->render('lister_trois_livres.html.twig', [
            'auteurs' => $repo->listerAuMoins3()
        ]);


    }

    /**
     * @Route("/action17", name="action17")
     */

    public function ListerParSexe(LivreRepository $repo){

       
        return $this->render('liste_parite.html.twig', [
            'livres' => $repo->listerParParite()
        ]);
    }


     /**
     * @Route("/action18", name="action18")
     */

    public function ListerGenreAuteur(GenreRepository $repo){

        $genres = $repo->listerGenreParAuteur();
        dump($genres);
       
        return $this->render('liste_genre.html.twig', [
            'genres' => $genres
        ]);
    }



     /**
     * @Route("/action19", name="action19")
     */

    public function nbTotalGenre(Request $request, GenreRepository $repo){


        $form = $this ->createFormBuilder()
                    ->add('nom_genre',TextType::class)
                    ->add('Valider',SubmitType::class)
                    ->getForm();
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {   
            $data = $form->getData();
            $genre=$data['nom_genre'];
            return $this->render ('resultat_nbtotal.html.twig',[
                'genres' => $repo->afficherNbPages($genre)
            ]);
        }
       
        return $this->render('form_nom_genre.html.twig', [
            'form' => $form->createview()
        ]);
    }

     
}
