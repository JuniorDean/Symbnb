<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture 
{   
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {   
        
        $faker = Factory::create("FR-fr");

        // Nous gérons les utilisateurs

        $user = [];
        $genres = ['male', 'female'];

        for($i = 1;$i <= 30;$i++){
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            $picture = $picture . ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');
 
            $user->setlastName($faker->lastName($genre))
                 ->setfirstName($faker->firstName)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>'. join('</p><p>', $faker->paragraphs(3)) .'</p>')
                 ->setHash($hash)
                 ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;
        }

        // Nous gérons les annonces 
        for($i = 1;$i <= 30; $i++){

            // On veux crée une nouvelle annonce
            $ad = new Ad();

            $title = $faker->sentence();

            $coverImage   = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content      = '<p>'. join('</p><p>', $faker->paragraphs(5)) .'</p>';

            $user = $users[mt_rand(0, count($users) -1)];

            $ad ->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(30, 80)) // La propriété mt_rand offre la positibilié tde cibler deux nombres 
                ->setRooms(mt_rand(1,5)) // La propriété mt_rand offre la positibilié tde cibler deux nombres
                ->setAuthor($user);
            
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
