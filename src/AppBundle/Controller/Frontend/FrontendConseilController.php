<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("conseil")
 */
class FrontendConseilController extends Controller
{
    /**
     * @Route("/", name="frontend_conseiller")
     */
    public function listAction()
    {
        $conseils = $this->getDoctrine()->getManager()->getRepository('AppBundle:Conseiller');//dump($conseils->findTitreList('conseil'));die();

        return $this->render('frontend/conseil_list.html.twig', [
            'adjoints' => $conseils->findTitreList('adjoint'),
            'conseillers' => $conseils->findTitreList('conseil')
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_conseiller_show")
     */
    public function showAction($slug)
    {
        $conseiller = $this->getDoctrine()->getManager()->getRepository('AppBundle:Conseiller')->findOneBy(array('slug'=> $slug));

        return $this->render('frontend/conseil_show.html.twig',[
            'conseiller' => $conseiller,
        ]);
    }
}
