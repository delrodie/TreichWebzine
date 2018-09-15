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
        $agendas = $em->getRepository('AppBundle:Agenda')->findListDesc(1);
        $actualites1 = $em->getRepository('AppBundle:Actualite')->findListDesc(1, 2,0);
        $actualites2 = $em->getRepository('AppBundle:Actualite')->findListDesc(1,2,2);
        $lifestyleIntros = $em->getRepository('AppBundle:Lifestyle')->findLifestyleActifDesc(1,0);
        $lifestyles = $em->getRepository('AppBundle:Lifestyle')->findLifestyleActifDesc(4,1);
        $sliders = $em->getRepository('AppBundle:Slider')->findListDesc(1,6,0);
        return $this->render('default/index.html.twig', [
            'agendas' => $agendas,
            'actualites1' => $actualites1,
            'actualites2' => $actualites2,
            'lifestyleIntros' => $lifestyleIntros,
            'lifestyles' => $lifestyles,
            'sliders' => $sliders,
        ]);
    }

    /**
     * Block droit de l'interface
     *
     * @route("/block-droite", name="homepage_droit")
     */
    public function blockdoitAction()
    {
        $em = $this->getDoctrine()->getManager();
        $infos = $em->getRepository('AppBundle:Information')->findListDesc(1, 4,0);
        $dossiers = $em->getRepository('AppBundle:Dossier')->findListDesc(1,4,0);

        return $this->render('default/block_droit.html.twig',[
            'infos' => $infos,
            'dossiers' => $dossiers,
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
