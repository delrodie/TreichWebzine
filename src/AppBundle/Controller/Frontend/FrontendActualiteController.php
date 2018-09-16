<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendActualiteController
 * @Route("actualites")
 */
class FrontendActualiteController extends Controller
{
    /**
     * @Route("/", name="frontend_actualite")
     */
    public function listAction()
    {
        $actualites = $this->getDoctrine()->getManager()->getRepository('AppBundle:Actualite');
        if ($actualites->compteur(1) < 5 ){
            $actualite1 = $actualites->findListDesc(1,2,0);
            $actualite2 = $actualites->findListDesc(1,2,2);
        }else{
            $actualite1 = $actualites->findListDesc(1,3,0);
            $actualite2 = $actualites->findListDesc(1,3,3);
        }

        return $this->render('frontend/actualite_list.html.twig', [
            'actualite1s' => $actualite1,
            'actualite2s' => $actualite2,
        ]);
    }

    /**
     * @Route("/{type}/{slug}", name="frontend_actualite_show")
     */
    public function showAction($type, $slug)
    {
        $actualites = $this->getDoctrine()->getManager()->getRepository('AppBundle:Actualite');
        $actualite = $actualites->findOneBy(array('slug'=> $slug));
        $similaires = $actualites->findTypeListDesc($type,null,4,0);

        return $this->render('frontend/actualite_show.html.twig',[
            'actualite' => $actualite,
            'similaires' => $similaires
        ]);
    }

    /**
     * @Route("/{type}-compteur", name="frontend_actualite_compteur")
     */
    public function compteurAction($type)
    {
        $compteur = $this->getDoctrine()->getManager()->getRepository('AppBundle:Actualite')->compteur(1,$type);
        return $this->render('default/compteur.html.twig',[
            'compteur' => $compteur,
        ]);
    }

    /**
     * @Route("/{type}/", name="frontend_actualite_type")
     */
    public function typeAction($type)
    {
        $actualites = $this->getDoctrine()->getManager()->getRepository('AppBundle:Actualite');//dump($actualites->compteur(1, $type));die();
        if ($actualites->compteur(1, $type) <5){
            $actualite1 = $actualites->findTypeListDesc($type, null,2,0);
            $actualite2 = $actualites->findTypeListDesc($type,null,2,2);
        }else{
            $actualite1 = $actualites->findTypeListDesc($type,null,3,0);
            $actualite2 = $actualites->findTypeListDesc($type,null,3,3);
        }

        return $this->render('frontend/actualite_list.html.twig',[
            'actualite1s' => $actualite1,
            'actualite2s' => $actualite2
        ]);
    }
}
