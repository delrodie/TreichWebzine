<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendDossierController
 * @Route("dossier")
 */
class FrontendDossierController extends Controller
{
    /**
     * @Route("/", name="frontend_dossier")
     */
    public function listAction()
    {
        $dossiers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Dossier');

        if ($dossiers->compteur(1) < 5){
            $dossier1 = $dossiers->findListDesc(1,2,0);
            $dossier2 = $dossiers->findListDesc(1,2,2);//dump($dossier2);die();
        }else{
            $dossier1 = $dossiers->findListDesc(1,3,0);
            $dossier2 = $dossiers->findListDesc(1,3,3);
        }
        return $this->render('frontend/dossier_list.html.twig', [
            'dossier1s' => $dossier1,
            'dossier2s' => $dossier2,
        ]);
    }

    /**
     * @Route("/{type}/{slug}", name="frontend_dossier_show")
     */
    public function showAction($type, $slug)
    {
        $dossiers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Dossier');
        $dossier = $dossiers->findOneBy(array('slug'=> $slug));
        $similaires = $dossiers->findlistByType($type, $slug, 4,0);

        return $this->render('frontend/dossier_show.html.twig',[
            'dossier' => $dossier,
            'similaires' => $similaires
        ]);
    }

    /**
     * @Route("/compteur", name="frontend_dossier_compteur")
     */
    public function compteurAction()
    {
        $dossier = $this->getDoctrine()->getManager()->getRepository('AppBundle:Dossier'); //dump($dossier);die();
        return $this->render('default/compteur.html.twig',[
            'compteur' => $dossier->compteur(null,null),
        ]);
    }

    /**
     * Liste des articles selon le type de dossier
     * @Route("/{type}/", name="frontend_dossier_type")
     */
    public function typeAction($type)
    {
        $dossiers = $this->getDoctrine()->getManager()->getRepository('AppBundle:Dossier');
        if ($dossiers->compteur(1, $type) < 5){
            $dossier1 = $dossiers->findlistByType($type, null,2,0);
            $dossier2 = $dossiers->findlistByType($type, null,2,2);
        }else{
            $dossier1 = $dossiers->findlistByType($type, null,3,0);
            $dossier2 = $dossiers->findlistByType($type,null,3,3);
        }
        return $this->render('frontend/dossier_list.html.twig', [
            'dossier1s' => $dossier1,
            'dossier2s' => $dossier2,
        ]);
    }
}
