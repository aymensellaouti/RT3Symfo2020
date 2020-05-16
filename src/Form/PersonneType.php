<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Personne;
use App\Entity\SocialMedia;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('firstname', TextareaType::class)
            ->add('age')
            ->add('path')
            ->add('cin')
            ->add('classe')
            ->add('image', FileType::class, array(
                'mapped' => false
            ))
            ->add('socialMedia', EntityType::class, array(
                'class' => SocialMedia::class,
                'expanded' => true,
                'multiple' => false
            ))
            ->add('cours',EntityType::class, array(
                'class' => Cours::class,
                'expanded' => true,
                'multiple' => true
            ))
//            ->add('pays', CountryType::class, array(
//                'mapped' => false
//            ) )
            ->add('Add Personne', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-danger'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
