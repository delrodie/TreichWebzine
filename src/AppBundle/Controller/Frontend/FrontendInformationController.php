<?php

namespace AppBundle\Controller\Frontend;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendInformation
 * @Route("information")
 */
class FrontendInformationController extends Controller
{
    /**
     * Liste des informations
     *
     * @Route("/", name="frontend_informations")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $infos = $em->getRepository('AppBundle:Information')->findListDesc(1,6,0);

        return $this->render('frontend/info_flash.html.twig',[
            'infos' => $infos
        ]);
    }
}