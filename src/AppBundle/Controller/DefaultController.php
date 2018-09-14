<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $agendas = $em->getRepository('AppBundle:Agenda')->findAgendaDescActif();
        $actualites1 = $em->getRepository('AppBundle:Actualite')->findFindActualiteDescActif(2,0);
        $actualites2 = $em->getRepository('AppBundle:Actualite')->findFindActualiteDescActif(2,2);
        $infos = $em->getRepository('AppBundle:Information')->findInfoDescActive(4,0);
        return $this->render('default/index.html.twig', [
            'agendas' => $agendas,
            'actualites1' => $actualites1,
            'actualites2' => $actualites2,
            'infos' => $infos,
        ]);
    }

    /**
     * @Route("/backend/dashboard", name="backend")
     */
    public function backendAction()
    {
        return $this->render('default/dashboard.html.twig');
    }
}
