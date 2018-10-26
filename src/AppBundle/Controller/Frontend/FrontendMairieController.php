<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrontendMairieController
 * @Route("mairie")
 */
class FrontendMairieController extends Controller
{
    /**
     * @Route("/menu-maire", name="frontend_maire_menu")
     */
    public function menuAction()
    {
        $maires = $this->getDoctrine()->getManager()->getRepository('AppBundle:Maire');
        return $this->render('frontend/maire_menu.html.twig',[
            'menus' => $maires->findList(1,1,0),
        ]);
    }

    /**
     * @Route("/{slug}/", name="frontend_municipalite")
     */
    public function municipaliteAction($slug)
    {
        $municipalites = $this->getDoctrine()->getManager()->getRepository('AppBundle:Municipalite');
        return $this->render('frontend/municipalite_show.html.twig',[
            'municipalite' => $municipalites->findOneBy(array('slug'=>$slug)),
        ]);
    }

    /**
     * @Route("/le-maire/{slug}", name="frontend_maire_show")
     */
    public function maireAction($slug)
    {
        $maire = $this->getDoctrine()->getManager()
                        ->getRepository('AppBundle:Maire')
                        ->findOneBy(array('slug'=> $slug));

        return$this->render('frontend/maire_show.html.twig',[
            'maire' => $maire,
        ]);
    }
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/conseil/municiapl/menu", name="frontend_municipalite_menu")
     */
    public function municipalitemenuAction()
    {
        $conseils = $this->getDoctrine()->getManager()->getRepository('AppBundle:Municipalite');

        return $this->render('frontend/municipalite_menu.html.twig',[
            'menus' => $conseils->findBy(array('statut'=>1), array('id'=> 'DESC'), 1, 0)
        ]);
    }
}
