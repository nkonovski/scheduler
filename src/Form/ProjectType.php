<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder
           ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
           ->add('submit', SubmitType::class,[
                   'attr' => ['class' => 'form-control btn-success'],
                   'label' => 'Create']
           )
       ;
   }

   public function configureOptions(OptionsResolver $resolver)
   {
       $resolver->setDefaults([
           // uncomment if you want to bind to a class
           'data_class' => Project::class,
       ]);
   }
}