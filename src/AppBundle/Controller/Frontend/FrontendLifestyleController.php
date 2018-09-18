<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendLifestyleController
 * @Route("lifestyle")
 */
class FrontendLifestyleController extends Controller
{
    /**
     * @Route("/", name="frontend_lifestyle")
     */
    public function listAction()
    {
        $lifestyles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lifestyle');
        if ($compteur = $lifestyles->compteur(null,1) < 5){
            $lifestyle1 = $lifestyles->findListDesc(1,2,0);
            $lifestyle2 = $lifestyles->findListDesc(1,2,2);
        }else{
            $lifestyle1 = $lifestyles->findListDesc(1,3,0);
            $lifestyle2 = $lifestyles->findListDesc(1,3,3);
        }
        return $this->render('frontend/lifestyle_list.html.twig', [
            'lifestyle1s' => $lifestyle1,
            'lifestyle2s' => $lifestyle2
        ]);
    }

    /**
     * @Route("/{type}/", name="frontend_lifestyle_type")
     */
    public function typeAction($type)
    {
        $lifestyles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lifestyle');
        if ($lifestyles->compteur($type,1) < 5){
            $lifestyle1 = $lifestyles->findTypeDesc($type,1,2,0);
            $lifestyle2 = $lifestyles->findTypeDesc($type,1,2,2);
        }else{
            $lifestyle1 = $lifestyles->findTypeDesc($type,1,3,0);
            $lifestyle2 = $lifestyles->findTypeDesc($type,1,3,3);
        }

        return $this->render('frontend/lifestyle_list.html.twig',[
            'lifestyle1s' => $lifestyle1,
            'lifestyle2s' => $lifestyle2
        ]);
    }

    /**
     * @Route("/{type}/{slug}", name="frontend_lifestyle_show")
     */
    public function showAction($type, $slug)
    {
        $lifestyles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Lifestyle');
        $lifestyle = $lifestyles->findOneBy(array('slug'=>$slug));
        $similaires = $lifestyles->findListDesc(1,4,0);

        return $this->render('frontend/lifestyle_show.html.twig',[
            'lifestyle' => $lifestyle,
            'similaires' => $similaires
        ]);
    }
}
