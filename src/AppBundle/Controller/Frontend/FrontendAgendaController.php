<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FrontendAgendaController
 * @Route("agenda")
 */
class FrontendAgendaController extends Controller
{
    /**
     * @Route("/", name="frontend_agenda")
     */
    public function listAction()
    {
        $agendas = $this->getDoctrine()->getManager()->getRepository('AppBundle:Agenda');

        if($agendas->compteur(1) < 5){
            $agenda1 = $agendas->findListDesc(1,2,0);
            $agenda2 = $agendas->findListDesc(1,2,2);
        } else{
            $agenda1 = $agendas->findListDesc(1,3,0);
            $agenda2 = $agendas->findListDesc(1,3,3);
        }

        return $this->render('frontend/agenda_list.html.twig',[
            'agenda1s' => $agenda1,
            'agenda2s' => $agenda2,
        ]);
    }

    /**
     * @Route("/{type}/{slug}", name="frontend_agenda_show")
     */
    public function showAction($type, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $agenda = $em->getRepository('AppBundle:Agenda')->findOneBy(array('slug'=> $slug));
        $similaires = $em->getRepository('AppBundle:Agenda')->findListDesc(1);

        return $this->render('frontend/agenda_show.html.twig',[
            'agenda' => $agenda,
            'similaires' => $similaires,
        ]);
    }

    /**
     * Compteur du nombre d'articles
     *
     * @Route("/compteur", name="frontend_agenda_compteur")
     */
    public function compteurAction()
    {
        $agendas = $this->getDoctrine()->getManager()->getRepository('AppBundle:Agenda');
        return $this->render('default/compteur.html.twig',[
            'compteur' => $agendas->compteur(1),
        ]);
    }
}
