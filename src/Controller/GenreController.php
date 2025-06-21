<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Entity\Acteur;
use App\Form\Genreacteur2filmsType;
use App\Repository\ActeurRepository;
use App\Repository\FilmRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Persistence\ManagerRegistry;

class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="genre")
     */
    public function index(): Response
    {
        return $this->render('genre/index.html.twig', [
            'controller_name' => 'GenreController',
        ]);
    }

     /**
     * @Route("/ajouter_genre", name="genre_ajouter")
     */
    public function ajouter(Request $request)
    {
        $genre = new Genre;
        $form = $this->createFormBuilder($genre)
                     ->add('nom', TextType::class)
                     ->add('enregistrer', SubmitType::class)
                     ->getForm(); 
                     $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($genre);
               $entityManager->flush();
               return $this->redirectToRoute('genre_lister');
               } 
        return $this->render('genre/ajouter.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }

     /**
     * @Route("/Lister_genre", name="genre_lister")
     */
    public function lister(Request $request,GenreRepository $genreRepository){
        return $this->render('genre/lister.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    /** 
     *@Route("/supprimer_genre/{id}", name="genre_supprimer",methods={"GET","POST"})
     */
    public function supprimer($id){
        $genre = $this->getDoctrine()->getRepository(Genre::class)->find($id);
        if($genre) {
            if(count($genre->getlivres())==0)
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($genre);
        $entityManager->flush();
        $this->addFlash('succes','genre supprimer avec succès');
        }
        return $this->redirectToRoute('genre_lister');


    }

    /**
     * @Route("/add_gender", name="add_gender")
     */
    public function addgender(Request $request, ManagerRegistry $doctrine): Response
    {   
        $addgenre = new Genre();
        $formgenre = $this  ->createFormBuilder($addgenre)
                            ->add('nom', TextType::class, [
                                'attr' => [
                                    'placeholder' => "Nom du genre à ajouter",
                                    'class' => 'form-control'
                                ]
                            ])
                            ->add('save', SubmitType::class, [
                                'attr' => [
                                    'label' => "Ajouter le genre",
                                    'class' => "btn btn-primary"
                                ]
                            ])
                            ->getForm();
        $formgenre->handleRequest($request);
        if($formgenre->isSubmitted() && $formgenre->isValid())
        {
            $manager = $doctrine->getManager();
            $manager->persist($addgenre);
            $manager->flush();
            return $this->redirectToRoute('genre_lister');
        }
        return $this->render('form_gender.html.twig',[
            'controller_name' => 'GenderController',
            'formGenre' => $formgenre->createView()
        ]);
    }

    

    
}
