<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendSliderController
 * @Route("Slider")
 */
class FrontendSliderController extends Controller
{
    /**
     * @param $name
     * @Route("/", name="frontend_slider")
     */
    public function listAction($name)
    {
        $sliders = $this->getDoctrine()->getManager()->getRepository('AppBundle:Slider');

        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/compteur/", name="frontend_slider_compteur")
     */
    public function compteurAction()
    {
        $compteur = $this->getDoctrine()->getManager()->getRepository('AppBundle:Slider')->compteur();

        return $this->render('default/compteur.html.twig', [ 'compteur' => $compteur]);
    }
}
