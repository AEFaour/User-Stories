<?php

namespace App\Form;

use App\Entity\Advert;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File as AssertFile;

class AdvertType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('text', TextareaType::class, [
                'label' => 'Texte : ',
                'attr' => ['rows' => 15]])
            ->add('createdAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text'
            ])
            ->add('photo', FileType::class, [
                'label' => 'Télécharger le photo',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new AssertFile([
                        'maxSize'=>'1024k',
                        'mimeTypes' => [
                            'image/png', 'image/jpeg', 'image/gif'
                        ],
                        'maxSizeMessage' => 'Vous devez choisir de 5 Mo maximum',
                        'mimeTypesMessage' => 'Seuls les fichiers image web sont autorisés'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'Categorie de l\'annonce'
            ])
            ->add('user',  EntityType::class, [
                'class' => User::class,
                'choice_label' => 'Nom de l\'Utilisateur'
            ])
            ->add('submit', SubmitType::class,
                ["label" => "Valider", "attr" => ["class" => "btn btn-success"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Advert::class,
        ]);
    }
}
