<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendCommuneController
 * @Route("/commune")
 */
class FrontendCommuneController extends Controller
{
    /**
     * @Route("/menu", name="frontend_commune_menu")
     */
    public function menuAction()
    {
        $communes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commune');
        return $this->render('frontend/commune_menu.html.twig',[
            'menus' => $communes->findList(null,1),
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_commune_show")
     */
    public function showAction($slug)
    {
        $communes = $this->getDoctrine()->getManager()->getRepository('AppBundle:Commune');
        return $this->render('frontend/commune_show.html.twig', [
            'commune' => $communes->findOneBy(array('slug' => $slug)),
            'similaires' => $communes->findSimilaire($slug),
        ]);
    }
}
