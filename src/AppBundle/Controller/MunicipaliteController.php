<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Municipalite;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Municipalite controller.
 *
 * @Route("backend/municipalite")
 */
class MunicipaliteController extends Controller
{
    /**
     * Lists all municipalite entities.
     *
     * @Route("/", name="backend_municipalite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $municipalites = $em->getRepository('AppBundle:Municipalite')->findAll();

        return $this->render('municipalite/index.html.twig', array(
            'municipalites' => $municipalites,
        ));
    }

    /**
     * Creates a new municipalite entity.
     *
     * @Route("/new", name="backend_municipalite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $municipalite = new Municipalite();
        $form = $this->createForm('AppBundle\Form\MunicipaliteType', $municipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($municipalite->getContenu(), 300, '...', true);
            $municipalite->setResume($resume);
            $em->persist($municipalite);
            $em->flush();

            return $this->redirectToRoute('backend_municipalite_show', array('slug' => $municipalite->getSlug()));
        }

        return $this->render('municipalite/new.html.twig', array(
            'municipalite' => $municipalite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a municipalite entity.
     *
     * @Route("/{slug}", name="backend_municipalite_show")
     * @Method("GET")
     */
    public function showAction(Municipalite $municipalite)
    {
        $deleteForm = $this->createDeleteForm($municipalite);

        return $this->render('municipalite/show.html.twig', array(
            'municipalite' => $municipalite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing municipalite entity.
     *
     * @Route("/{slug}/edit", name="backend_municipalite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Municipalite $municipalite, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($municipalite);
        $editForm = $this->createForm('AppBundle\Form\MunicipaliteType', $municipalite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($municipalite->getContenu(), 300, '...', true);
            $municipalite->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_municipalite_show', array('slug' => $municipalite->getSlug()));
        }

        return $this->render('municipalite/edit.html.twig', array(
            'municipalite' => $municipalite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a municipalite entity.
     *
     * @Route("/{id}", name="backend_municipalite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Municipalite $municipalite)
    {
        $form = $this->createDeleteForm($municipalite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($municipalite);
            $em->flush();
        }

        return $this->redirectToRoute('backend_municipalite_index');
    }

    /**
     * Creates a form to delete a municipalite entity.
     *
     * @param Municipalite $municipalite The municipalite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Municipalite $municipalite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_municipalite_delete', array('id' => $municipalite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
