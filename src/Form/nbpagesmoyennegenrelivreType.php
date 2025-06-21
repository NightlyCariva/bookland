<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class nbpagesmoyennegenrelivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('genrenom',TextType::class,[
            'label' => ' le nombre des pages moyenne de tous les livres d’un genre donné :'
        ])

        ->add('chercher',SubmitType::class,[   
            'attr' =>['class'=>'btn btn-outline-success my-2 my-sm-0']  
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
