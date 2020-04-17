<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 

class HomeController extends AbstractController{
    /**
     * @Route("/NiqueTaMere/{prenom}/age/{age}", name="hello")
     * @Route("/salut/", name="homepage")
     * @Route("/what/{prenom}/", name="hello_prenom")
     * 
     * @return void
     */ 

    public function hello($prenom = "anonyme", $age = 30){
        return new Response("Bonjour " .$prenom. " vous avez " . $age . " ans ");
    }

    /** 
     * @Route("/", name="homepage")
     */
    public function home(){
        // Render est une fonction hérité directement grace au CONTROLLER
        // Cette fonction a besoin de 2 paramètres
        // 1) Le chemin du Template
        // 2) 

        $prenom = ["Cavani" => 31,"Veratti"=> 27," Mbappe"=> 23];

        return $this->render(
            'home.html.twig',
            [
               'title' => "Allez Paris",
               'age' => 12, 
               'tableau' => $prenom
            ]
        );
    }

}



?>