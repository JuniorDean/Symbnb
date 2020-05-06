<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {   
        // $repo = $this->getDoctrine()->getRepository(Ad::class);

        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet d'afficher une seule annonce 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     * 
     * 
     * Le ParamConverter est une brique de Symfony qui est vraiment très pratique. Comme son nom l'indique, son but est de convertir un paramètre d'une route en un véritable objet issu de la base de données. 
     * Par exemple, si une Route attend un paramètre "slug", on peut demander à Symfony de nous passer directement l'objet dont le slug est celui qu'on a reçu.
     * On a convertie le paramètre slug en une annonce
     */

    public function show(Ad $ad){
        // Je récupére l'annonce qui correspond au slug
        // $ad = $repo->findOneBySlug($slug);   
        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
   
    }

}
