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

    /**
     * @Route("/{type}/{slug}", name="frontend_information_show")
     */
    public function show($type, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $info = $em->getRepository('AppBundle:Information')->findOneBy(array('slug'=>$slug));
        $similaires = $em->getRepository('AppBundle:Information')->findListSimilaire($info->getTypinfo()->getId(), $info->getId(), 4,0);

        return $this->render("frontend/info_show.html.twig",[
            'info' => $info,
            'similaires' => $similaires,
        ]);
    }
}