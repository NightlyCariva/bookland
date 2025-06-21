<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Auteur;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\GenreRepository;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class InitController extends AbstractController
{   
     /**
     * @Route("/bookland/init", name="init")
     */
    
    public function init(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $genre1 = new Genre;
        $genre1->setNom("science fiction");

        $genre2 = new Genre;
        $genre2->setNom("policier");

        $genre3 = new Genre;
        $genre3->setNom("philosophie");

        $genre4 = new Genre;
        $genre4->setNom("économie");

        $genre5 = new Genre;
        $genre5->setNom("psychologie");

        $manager->persist($genre1);
        $manager->persist($genre2);
        $manager->persist($genre3);
        $manager->persist($genre4);

        $auteur1 = new Auteur;
        $auteur1->setNomPrenom("Cass Sunstein")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("23-11-1943"))
                ->setNationalite("allemagne");
                

        $auteur2 = new Auteur;
        $auteur2->setNomPrenom("Francis Gabrelot")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("29-01-1967"))
                ->setNationalite("france");
                

        $auteur3 = new Auteur;
        $auteur3->setNomPrenom("Richard Thaler")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("12-12-1945"))
                ->setNationalite("USA");
                

        $auteur4 = new Auteur;
        $auteur4->setNomPrenom("Ayn Rand")
                ->setSexe("F")
                ->setDateDeNaissance(new \DateTime("21-06-1950"))
                ->setNationalite("russie");
                

        $auteur5 = new Auteur;
        $auteur5->setNomPrenom("Duschmol")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("23-12-2001"))
                ->setNationalite("groland");

        $auteur6 = new Auteur;
        $auteur6->setNomPrenom("Nancy Grave")
                ->setSexe("F")
                ->setDateDeNaissance(new \DateTime("24-10-1952"))
                ->setNationalite("USA");
                
        $auteur7 = new Auteur;
        $auteur7->setNomPrenom("James Enckling")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("03-07-1970"))
                ->setNationalite("USA");
                

        $auteur8 = new Auteur;
        $auteur8->setNomPrenom("Jean Dupont")
                ->setSexe("M")
                ->setDateDeNaissance(new \DateTime("03-07-1970"))
                ->setNationalite("france");
                

        $manager->persist($auteur1);
        $manager->persist($auteur2);
        $manager->persist($auteur3);
        $manager->persist($auteur4);
        $manager->persist($auteur5);
        $manager->persist($auteur6);
        $manager->persist($auteur7);
        $manager->persist($auteur8);

        $livre1 = new Livre;
        $livre1->setIsbn("978-2-07-036822-8")
                ->setTitre("Symfonystique")
                ->setNbpages("117")
                ->setDateDeParution(new \DateTime("20-01-2008"))
                ->setNote("8")
                ->addAuteur($auteur3)
                ->addAuteur($auteur4)
                ->addAuteur($auteur6)
                ->addGenre($genre2)
                ->addGenre($genre3);

        $livre2 = new Livre;
        $livre2->setIsbn("978-2-251-44417-8")
                ->setTitre("La grève")
                ->setNbpages("1245")
                ->setDateDeParution(new \DateTime("12-06-1961"))
                ->setNote("19")
                ->addAuteur($auteur4)
                ->addAuteur($auteur7)
                ->addGenre($genre3);

        $livre3 = new Livre;
        $livre3->setIsbn("978-2-212-55652-0")
                ->setTitre("Symfonyland")
                ->setNbpages("131")
                ->setDateDeParution(new \DateTime("17-09-1980"))
                ->setNote("15")
                ->addAuteur($auteur8)
                ->addAuteur($auteur7)
                ->addAuteur($auteur4)
                ->addGenre($genre1);

        $livre4 = new Livre;
        $livre4->setIsbn("978-2-0807-1057-4")
                ->setTitre("Négociation Complexe")
                ->setNbpages("234")
                ->setDateDeParution(new \DateTime("25-09-1992"))
                ->setNote("16")
                ->addAuteur($auteur1)
                ->addAuteur($auteur2)
                ->addGenre($genre5);

        $livre5 = new Livre;
        $livre5->setIsbn("978-0-300-12223-7")
                ->setTitre("Ma vie")
                ->setNbpages("5")
                ->setDateDeParution(new \DateTime("08-11-2021"))
                ->setNote("03")
                ->addAuteur($auteur8)
                ->addGenre($genre2);

        $livre6 = new Livre;
        $livre6->setIsbn("978-0-141-18776-1")
                ->setTitre("Ma vie : suite")
                ->setNbpages("5")
                ->setDateDeParution(new \DateTime("09-11-2021"))
                ->setNote("01")
                ->addAuteur($auteur8)
                ->addGenre($genre2);

        $livre7 = new Livre;
        $livre7->setIsbn("978-0-141-18786-0")
                ->setTitre("Le monde comme volonté et comme représentation")
                ->setNbpages("1987")
                ->setDateDeParution(new \DateTime("09-11-1821"))
                ->setNote("19")
                ->addAuteur($auteur6)
                ->addAuteur($auteur3)
                ->addGenre($genre3);
        
        $manager->persist($livre1);
        $manager->persist($livre2);
        $manager->persist($livre3);
        $manager->persist($livre4);
        $manager->persist($livre5);
        $manager->persist($livre6);
        $manager->persist($livre7);
        
        
        
        
        $manager->flush();
        return $this->render('init/index.html.twig', [
            'controller_name' => 'InitController',
        ]);
    }
}
