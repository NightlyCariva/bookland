<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Form\LivreAuteur3Type;
use App\Form\LivreAuteurSearchType;
use App\Form\TwoauteursType;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Persistence\ManagerRegistry;

class AuteurController extends AbstractController
{  
   

     /**
     * @Route("/ajouter_auteur", name="auteur_ajouter",methods={"GET","POST"})
     */
   public function ajouter(Request $request)
    {
        $auteur = new Auteur;
        $form = $this->createFormBuilder($auteur)
                     ->add('nom_prenom', TextType::class,[
                         'attr'=> ['placeholder'=>"nom et prenom"]
                     ]) 
                     ->add('sexe', TextType::class,[
                        'attr'=> ['placeholder'=>"sexe"]
                    ])
                     ->add('date_de_naissance', DateType::class, [
                        'widget' => 'single_text',])
                     ->add('nationalite', TextType::class,[
                        'attr'=> ['placeholder'=>"Nationalité"]
                    ])
                   
                     ->add('enregistrer', SubmitType::class)
                     ->getForm(); 
                     $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($auteur);
               $entityManager->flush();
               return $this->redirectToRoute('auteur_lister');
               } 
        return $this->render('auteur/ajouter.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
     /**
     * @Route("/Lister_auteur", name="auteur_lister")
     */
    public function lister(Request $request,auteurRepository $auteurRepository,LivreRepository $LivreRepository){
     
        return $this->render('auteur/lister.html.twig', [
            'auteures' => $auteurRepository->findAll(),
           
        ]);
    }
    
    
   /**
     * @Route("/detail_auteur/{id}", name="auteur_details")
     * 
     */
    public function show_Livre(Auteur $auteur,GenreRepository $genreRepository,AuteurRepository $auteurRepository): Response
    {
        return $this->render('auteur/details.html.twig', [
            'auteur' => $auteur,
            'genres'=>$genreRepository->findAuteurGneres1Livre($auteur->getid()),
            
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editauteur($id,Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = $this->getDoctrine()->getRepository(Auteur::class);
        $auteur_en_q = $repo->findOneBy(array('id' => $id));


        $formedit = $this ->createFormBuilder($auteur_en_q)
                        ->add('nom_prenom')
                        ->add('sexe')
                        ->add('date_de_naissance', DateType::class, [
                                'widget' => 'single_text',
                        ])
                        ->add('nationalite')
                        ->getForm();

        $formedit->handleRequest($request);
        
        if($formedit->isSubmitted() && $formedit->isValid())
        {
            $manager = $doctrine->getManager();
            $manager->persist($auteur_en_q);
            $manager->flush();
            return $this->redirectToRoute('auteur_lister');
        
        }

        return $this->render('edit_auteur.html.twig', [
                'controller_name' => 'AuthorController',
                'id' => $id,
                'auteur' => $auteur_en_q,
                'formAuteur' => $formedit->createView()
        ]);
    }

    /**
     * @Route("/addlivre/{id}", name="addlivre")
     */
    public function addlivre($id, Request $request, ManagerRegistry $doctrine ): Response
    {
        $manager = $doctrine->getManager(); 
        $repo_aut = $this->getDoctrine()->getRepository(Auteur::class);
        $auteur_en_q = $repo_aut->findOneBy(array('id' => $id));
        

        $formadd = $this ->createFormBuilder()
                        ->add('isbn')
                        ->add('Ajouter_le_livre', SubmitType::class, [
                                'attr' => [
                                    'class' => "btn btn-primary"
                                ]
                            ])
                        ->getForm();

        $formadd->handleRequest($request);
        $isbn = $formadd-> getData();

        if($formadd->isSubmitted() && $formadd->isValid())
        {
                $repo_liv = $this->getDoctrine()->getRepository(Livre::class);
                $livre_en_q = $repo_liv->findOneBy(array('isbn' => $isbn['isbn']));
                
                if(!empty($livre_en_q))
                {
                        $livre_en_q->addAuteur($auteur_en_q);
                        $manager->persist($livre_en_q);
                        $manager->flush();
                        return $this->redirectToRoute('auteur_lister');
                }
                else
                {
                        return $this->render("erreur_add_livre.html.twig", [
                                'isbn' => $isbn['isbn']
                        ]);
                }
        }
   
        return $this->render('addlivre_auteur.html.twig', [
                    'controller_name' => 'AuthorController',
                    'formadd' => $formadd->createView()
                    
        ]);
    }

    /**
     * @Route("/delet/{id}", name="delet")
     */
    public function deletauteur($id,ManagerRegistry $doctrine): Response
    {
        $repo = $this->getDoctrine()->getRepository(Auteur::class);
        $auteur_en_q = $repo->findOneBy(array('id' => $id));

        $manager = $doctrine->getManager();
        $manager->remove($auteur_en_q);
        $manager->flush();

        return $this->redirectToRoute('auteur_lister');
    }

}
