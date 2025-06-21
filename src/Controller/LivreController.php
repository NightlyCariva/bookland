<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Form\AugmenternoteType;
use App\Form\nbpagesmoyennegenrelivreType;
use App\Form\DureetotalauteurType;
use App\Form\LivreAnterieurDate;
use App\Form\LivreSearchType;
use App\Form\RecherechelivreType;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\LivreType;
use Doctrine\Persistence\ManagerRegistry;



class LivreController extends AbstractController
{
    /**
     * @Route("/livre", name="livre")
     */
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }

     /**
     * @Route("/ajouter_livre", name="livre_ajouter")
     */
    public function ajouter(Request $request)
    {
        $livre = new livre;
        $form = $this->createFormBuilder($livre)
                    ->add('Isbn', TextType::class)
                     ->add('titre', TextType::class)
                     ->add('date_de_parution', DateType::class, [
                        'widget' => 'single_text',])
                     ->add('nbpages', IntegerType::class)
                     ->add('note', IntegerType::class)
                     
                     ->add('enregister',SubmitType::class)
                     ->getForm(); 
                     $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($livre);
               $entityManager->flush();
               return $this->redirectToRoute('livre_lister');
               } 
        return $this->render('livre/ajouter.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
     /**
     * @Route("/auteur_livre", name="livre_auteur")
     */
    public function livreauteur(Request $request)
    {
        $auteurlivre = new auteur ;
        $form = $this->createFormBuilder($auteurlivre)
                     ->add('nomPrenom', EntityType::class,[
                         'class'=> auteur::class,
                          'choice_label'=>'nomPrenom'
                     ])
                    
                     ->add('enregister',SubmitType::class)
                     ->getForm(); 
                     $form->handleRequest($request);
           if ($form->isSubmitted() && $form->isValid()) {
               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($auteurlivre);
               $entityManager->flush();
               } 
        return $this->render('livre/livreauteur.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
    /**
     * @Route("/Lister_livre", name="livre_lister")
     */
    public function lister(Request $request, LivreRepository $LivreRepository){
        $form4 = $this->createForm(nbpagesmoyennegenrelivreType::class);
         $form4->handleRequest($request);

        $form5 = $this->createForm(RecherechelivreType::class);
        $form5->handleRequest($request);

        if ($form5->isSubmitted() && $form5->isValid()) {
           $data = $form5->getData();

           return $this->render('livre/lister.html.twig', [
               'livres' => $LivreRepository->findbypartietitre($data['titre']),
               'form4' =>$form4->createView(),
               'form5'=>$form5->createView(),
               'livre' => 0,
               'nbpagesmoyenne'=>0
               ]);
        }
        if ($form4->isSubmitted() && $form4->isValid()) {
         
            $data = $form4->getdata();
            return $this->render('livre/lister.html.twig', [
              
                'form4' =>$form4->createView(),
                'form5'=>$form5->createView(),
                'livres' => $LivreRepository->findbygenre($data['genrenom']),
                
                'nbpagesmoyenne'=>$LivreRepository->findpagesmoyenne($data['genrenom']),
               
                ]);
         }
         
        return $this->render('livre/lister.html.twig', [
            'livres' => $LivreRepository->findAll(),
            'form4' =>$form4->createView(),
            'form5' =>$form5->createView(),
            'livre' => 0,
            'nbpagesmoyenne'=>0
           
           
        ]);
    

    }
    
    
    /**
     * @Route("/details_livre/{id}", name="livre_details") 
     */
    public function show_film(Livre $livre): Response
    {
        return $this->render('livre/details.html.twig', [
            'livre' => $livre,

        ]);
    }
     /**
     * @Route("/augmenter_note/{id}", name="note_augmenter")
     */
    public function augmenternote($id){
        $livre = $this->getDoctrine()->getRepository(Livre :: class)->find($id);
        if($livre){
            if($livre->getNote()==20){

                $livre->setNote($livre->getNote());
            }
            else {
            $livre->setNote($livre->getNote()+1);
            $this->getDoctrine()->getManager()->flush();
            
            }
            return $this->redirectToRoute('livre_details',['id'=>$livre->getId()]);
        }
        


        return $this->redirectToRoute('livre_details');

    }
    /**
     * @Route("/reduire_note/{id}", name="note_reduire")
     */
    public function reduirenote($id){
        $livre = $this->getDoctrine()->getRepository(Livre :: class)->find($id);
        if($livre){

            if($livre->getNote()==0){

                $livre->setNote($livre->getNote());
            }
           
           else{
            $livre->setNote($livre->getNote()-1);
            $this->getDoctrine()->getManager()->flush();
           }

           return $this->redirectToRoute('livre_details',['id'=>$livre->getId()]);
        }
        return $this->redirectToRoute('livre_details');

     

    }


     /**
     * @Route("/augmenter_film", name="livre_augmenter")
     */
   
    public function augmenter(Request $request, LivreRepository $livreRepository){
        
        $form = $this->createForm(AugmenternoteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $data = $form->getData();
          $valeur = $data['valeur'];
            if($valeur==null){

                $valeur = 1;

            }
            if($valeur < 0 ){

                $valeur = 0;

            }
    
             $auteur = $data['auteur'];
             dump($auteur->getLivres());
             $livres=$auteur->getLivres();

             foreach($livres as $livre){
                 if( $livre->getnote()+$valeur > 20){
                 $var = 20 - $livre->getnote() ;
                    $livre->setnote($livre->getnote()+ $var);
                 }
                 else{
                  $livre->setnote($livre->getnote() + $valeur);
                 }
                  $this->getDoctrine()->getManager()->flush();
                
                  
             }

           return $this->redirectToRoute('livre_lister');
        }

            return $this->render('livre/augmenterlivre.html.twig', [
            'formulaire' => $form->createView(),
        ]);
    }
     /**
     * @Route("/auteur_lister_genre", name="auteur_lister_genre")
     */
    public function auteurlistergenre(LivreRepository $auteur){
        return $this->render('genre/listergenreauteur.html.twig', [
            'auteurs' => $auteur->findgenreauteur()
        ]); 

    }
    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    

            return $this->redirectToRoute('livre_lister', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/delete/{id}", name="livre_delete", methods={"GET","POST"})
     */
    public function delete($id,ManagerRegistry $doctrine): Response
    {
        $repo = $this->getDoctrine()->getRepository(Livre::class);
        $livre_en_q = $repo->findOneBy(array('id' => $id));

        $manager = $doctrine->getManager();
        $manager->remove($livre_en_q);
        $manager->flush();

        return $this->redirectToRoute('livre_lister', [], Response::HTTP_SEE_OTHER);
    }
 
    
}
