<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {   
        
        $faker = Factory::create("FR-fr");


        for($i = 1;$i <= 30; $i++){

            // On veux crée une nouvelle annonce
            $ad = new Ad();

            $title = $faker->sentence();

            $coverImage   = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content      = '<p>'. join('</p><p>', $faker->paragraphs(5)) .'</p>';

            $ad ->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(30, 80)) // La propriété mt_rand offre la positibilié tde cibler deux nombres 
                ->setRooms(mt_rand(1,5)); // La propriété mt_rand offre la positibilié tde cibler deux nombres
            
            // Les annonces auront entre 2 et 5 images d'ou la boucle For
            for($j = 1;$j <= mt_rand(2,5); $j++){
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);
                      
                      $manager->persist($image);
            }
            // Manager->persist consiste a sauvegarder dans le temps nos données 
            $manager->persist($ad);

            $manager->flush();
        }

    }
}
