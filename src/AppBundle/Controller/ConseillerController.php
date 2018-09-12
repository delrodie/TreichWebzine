<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conseiller;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conseiller controller.
 *
 * @Route("backend/conseiller")
 */
class ConseillerController extends Controller
{
    /**
     * Lists all conseiller entities.
     *
     * @Route("/", name="backend_conseiller_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conseillers = $em->getRepository('AppBundle:Conseiller')->findAllAsc();

        return $this->render('conseiller/index.html.twig', array(
            'conseillers' => $conseillers,
        ));
    }

    /**
     * Creates a new conseiller entity.
     *
     * @Route("/new", name="backend_conseiller_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $conseiller = new Conseiller();
        $form = $this->createForm('AppBundle\Form\ConseillerType', $conseiller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resume = $utilities->resume($conseiller->getBiographie(), 300, '...', true);
            $conseiller->setResume($resume);
            $em = $this->getDoctrine()->getManager();
            $em->persist($conseiller);
            $em->flush();

            return $this->redirectToRoute('backend_conseiller_show', array('slug' => $conseiller->getSlug()));
        }

        return $this->render('conseiller/new.html.twig', array(
            'conseiller' => $conseiller,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conseiller entity.
     *
     * @Route("/{slug}", name="backend_conseiller_show")
     * @Method("GET")
     */
    public function showAction(Conseiller $conseiller)
    {
        $deleteForm = $this->createDeleteForm($conseiller);

        return $this->render('conseiller/show.html.twig', array(
            'conseiller' => $conseiller,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conseiller entity.
     *
     * @Route("/{slug}/edit", name="backend_conseiller_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Conseiller $conseiller, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($conseiller);
        $editForm = $this->createForm('AppBundle\Form\ConseillerType', $conseiller);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($conseiller->getBiographie(), 300, '...', true);
            $conseiller->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_conseiller_show', array('slug' => $conseiller->getSlug()));
        }

        return $this->render('conseiller/edit.html.twig', array(
            'conseiller' => $conseiller,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conseiller entity.
     *
     * @Route("/{id}", name="backend_conseiller_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Conseiller $conseiller)
    {
        $form = $this->createDeleteForm($conseiller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($conseiller);
            $em->flush();
        }

        return $this->redirectToRoute('backend_conseiller_index');
    }

    /**
     * Creates a form to delete a conseiller entity.
     *
     * @param Conseiller $conseiller The conseiller entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conseiller $conseiller)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_conseiller_delete', array('id' => $conseiller->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
