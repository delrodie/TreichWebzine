<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MairieRubrique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mairierubrique controller.
 *
 * @Route("backend/mairierubrique")
 */
class MairieRubriqueController extends Controller
{
    /**
     * Lists all mairieRubrique entities.
     *
     * @Route("/", name="backend_mairierubrique_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mairieRubriques = $em->getRepository('AppBundle:MairieRubrique')->findAll();

        $mairieRubrique = new Mairierubrique();
        $form = $this->createForm('AppBundle\Form\MairieRubriqueType', $mairieRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mairieRubrique);
            $em->flush();

            return $this->redirectToRoute('backend_mairierubrique_index');
        }

        return $this->render('mairierubrique/index.html.twig', array(
            'mairieRubriques' => $mairieRubriques,
            'mairieRubrique' => $mairieRubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new mairieRubrique entity.
     *
     * @Route("/new", name="backend_mairierubrique_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mairieRubrique = new Mairierubrique();
        $form = $this->createForm('AppBundle\Form\MairieRubriqueType', $mairieRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mairieRubrique);
            $em->flush();

            return $this->redirectToRoute('backend_mairierubrique_show', array('id' => $mairieRubrique->getId()));
        }

        return $this->render('mairierubrique/new.html.twig', array(
            'mairieRubrique' => $mairieRubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mairieRubrique entity.
     *
     * @Route("/{id}", name="backend_mairierubrique_show")
     * @Method("GET")
     */
    public function showAction(MairieRubrique $mairieRubrique)
    {
        $deleteForm = $this->createDeleteForm($mairieRubrique);

        return $this->render('mairierubrique/show.html.twig', array(
            'mairieRubrique' => $mairieRubrique,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mairieRubrique entity.
     *
     * @Route("/{slug}/edit", name="backend_mairierubrique_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MairieRubrique $mairieRubrique)
    {
        $em = $this->getDoctrine()->getManager();

        $mairieRubriques = $em->getRepository('AppBundle:MairieRubrique')->findAll();

        $deleteForm = $this->createDeleteForm($mairieRubrique);
        $editForm = $this->createForm('AppBundle\Form\MairieRubriqueType', $mairieRubrique);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_mairierubrique_index');
        }

        return $this->render('mairierubrique/edit.html.twig', array(
            'mairieRubrique' => $mairieRubrique,
            'mairieRubriques' => $mairieRubriques,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mairieRubrique entity.
     *
     * @Route("/{id}", name="backend_mairierubrique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MairieRubrique $mairieRubrique)
    {
        $form = $this->createDeleteForm($mairieRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mairieRubrique);
            $em->flush();
        }

        return $this->redirectToRoute('backend_mairierubrique_index');
    }

    /**
     * Creates a form to delete a mairieRubrique entity.
     *
     * @param MairieRubrique $mairieRubrique The mairieRubrique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MairieRubrique $mairieRubrique)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_mairierubrique_delete', array('id' => $mairieRubrique->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
