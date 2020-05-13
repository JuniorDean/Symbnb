<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * Permet d'afficher une nouvelle annonce 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Response
     * 
     */

    public function create(Request $request, EntityManagerInterface $manager){

        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        dump($ad);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce<strong>YO</strong> a bien été enregistrer"
            );

            return $this->redirectToRoute('ads_show',[
                'slug' => $ad->getSlug()
            ]);
        }
    
        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
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
