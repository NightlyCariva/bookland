<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AugmenternoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('auteur',EntityType::class,[
            'label' => 'entrez le nom de l auteur:',
            'class'=>Auteur::class
        ])
        ->add('valeur',IntegerType::class,[
            'label' => 'entrez la valeur que vous voulez ajouter à la note:',
            'required'   => false, 
        ])

        ->add('augmenter',SubmitType::class,[   
            'attr' =>['class'=>'btn btn-outline-success my-2 my-sm-0']  
        ]);
        
    
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
