<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AdType extends AbstractType
{   

    /*
    * Cette fonction permet de ne pas se répétez    
    * @param string $label
    * @param string placeholder
    * return array
    */

    private function getConfiguration($label, $placeholder){
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]    
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
            TextType::class,
             $this->getConfiguration("Titre","Tapez un super titre")
            )
            ->add('slug',TextType::class,
             $this->getConfiguration("Adresse web",
             "Tapez l'adresse web(automatique)")
            )
            ->add('cover_image', UrlType::class,
             $this->getConfiguration("URL de l'image",
             "Donnez l'adresse d'une image qui donne vraiment envie ")
            )
            ->add('introduction', TextType::class,
             $this->getConfiguration("Introduction",
             "Donnez une descrption globale de l'annonce")
            )
            ->add('content', TextareaType::class,
            $this->getConfiguration("Description détaillé",
            "Tapez une description qui donne envie")
            )
            ->add('price', MoneyType::class,
             $this->getConfiguration("Prix par nuit",
             "Indiqué le prix que vous souhaitez")
            ) 
            ->add('rooms', IntegerType::class,
             $this->getConfiguration("Nombre de chambre",
              "Le nombre de chambre disponible")
            )
            ->add(
                'images', 
                CollectionType::class,
            [
                'entry_type' => ImageType::class,
                'allow_add' => true
            
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
