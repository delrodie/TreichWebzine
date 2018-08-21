<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commune;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Utils\Utilities;

/**
 * Commune controller.
 *
 * @Route("backend/commune")
 */
class CommuneController extends Controller
{
    /**
     * Lists all commune entities.
     *
     * @Route("/", name="backend_commune_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $communes = $em->getRepository('AppBundle:Commune')->findAll();

        return $this->render('commune/index.html.twig', array(
            'communes' => $communes,
        ));
    }

    /**
     * Creates a new commune entity.
     *
     * @Route("/new", name="backend_commune_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $commune = new Commune();
        $form = $this->createForm('AppBundle\Form\CommuneType', $commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($commune->getContenu(), 300, '...', true);
            $commune->setResume($resume);
            $em->persist($commune);
            $em->flush();

            return $this->redirectToRoute('backend_commune_show', array('slug' => $commune->getSlug()));
        }

        return $this->render('commune/new.html.twig', array(
            'commune' => $commune,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commune entity.
     *
     * @Route("/{slug}", name="backend_commune_show")
     * @Method("GET")
     */
    public function showAction(Commune $commune)
    {
        $deleteForm = $this->createDeleteForm($commune);

        return $this->render('commune/show.html.twig', array(
            'commune' => $commune,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commune entity.
     *
     * @Route("/{slug}/edit", name="backend_commune_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commune $commune, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($commune);
        $editForm = $this->createForm('AppBundle\Form\CommuneType', $commune);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($commune->getContenu(), 300, '...', true);
            $commune->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_commune_show', array('slug' => $commune->getSlug()));
        }

        return $this->render('commune/edit.html.twig', array(
            'commune' => $commune,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commune entity.
     *
     * @Route("/{id}", name="backend_commune_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commune $commune)
    {
        $form = $this->createDeleteForm($commune);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commune);
            $em->flush();
        }

        return $this->redirectToRoute('backend_commune_index');
    }

    /**
     * Creates a form to delete a commune entity.
     *
     * @param Commune $commune The commune entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commune $commune)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_commune_delete', array('id' => $commune->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
