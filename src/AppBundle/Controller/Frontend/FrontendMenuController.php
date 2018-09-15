<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendMenuController
 * @Route ("menu")
 */
class FrontendMenuController extends Controller
{
    /**
     * Menu de l'actualites
     *
     * @Route("/", name="frontend_menu")
     */
    public function menuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $agendas = $em->getRepository('AppBundle:Agenda')->findListDesc(1,3,0);
        $dossiers = $em->getRepository('AppBundle:Dossier')->findListDesc(1,3,0);
        $politiques = $em->getRepository('AppBundle:Actualite')->findTypeListDesc('politique',null,3,0);
        $religions = $em->getRepository('AppBundle:Actualite')->findTypeListDesc('religion',null,3,0);
        $societes = $em->getRepository('AppBundle:Actualite')->findTypeListDesc('societe','education',3,0);
        $cultures = $em->getRepository('AppBundle:Actualite')->findTypeListDesc('culture','environnement',3,0);
        $sports = $em->getRepository('AppBundle:Actualite')->findTypeListDesc('sport','sante',3,0);

        return $this->render('frontend/menu_actualite.html.twig',[
            'agendas' => $agendas,
            'dossiers' => $dossiers,
            'politiques' => $politiques,
            'societes' => $societes,
            'cultures' => $cultures,
            'sports' => $sports,
            'religions' => $religions,
        ]);
    }
}