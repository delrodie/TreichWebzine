<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommuneRubrique;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Communerubrique controller.
 *
 * @Route("backend/communerubrique")
 */
class CommuneRubriqueController extends Controller
{
    /**
     * Lists all communeRubrique entities.
     *
     * @Route("/", name="backend_communerubrique_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $communeRubriques = $em->getRepository('AppBundle:CommuneRubrique')->findRubriqueASC();

        $communeRubrique = new Communerubrique();
        $form = $this->createForm('AppBundle\Form\CommuneRubriqueType', $communeRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($communeRubrique);
            $em->flush();

            return $this->redirectToRoute('backend_communerubrique_index');
        }

        return $this->render('communerubrique/index.html.twig', array(
            'communeRubriques' => $communeRubriques,
            'communeRubrique' => $communeRubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new communeRubrique entity.
     *
     * @Route("/new", name="backend_communerubrique_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $communeRubrique = new Communerubrique();
        $form = $this->createForm('AppBundle\Form\CommuneRubriqueType', $communeRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($communeRubrique);
            $em->flush();

            return $this->redirectToRoute('backend_communerubrique_show', array('id' => $communeRubrique->getId()));
        }

        return $this->render('communerubrique/new.html.twig', array(
            'communeRubrique' => $communeRubrique,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a communeRubrique entity.
     *
     * @Route("/{id}", name="backend_communerubrique_show")
     * @Method("GET")
     */
    public function showAction(CommuneRubrique $communeRubrique)
    {
        $deleteForm = $this->createDeleteForm($communeRubrique);

        return $this->render('communerubrique/show.html.twig', array(
            'communeRubrique' => $communeRubrique,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing communeRubrique entity.
     *
     * @Route("/{slug}/edit", name="backend_communerubrique_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommuneRubrique $communeRubrique)
    {
        $em = $this->getDoctrine()->getManager();

        $communeRubriques = $em->getRepository('AppBundle:CommuneRubrique')->findAll();

        $deleteForm = $this->createDeleteForm($communeRubrique);
        $editForm = $this->createForm('AppBundle\Form\CommuneRubriqueType', $communeRubrique);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_communerubrique_index');
        }

        return $this->render('communerubrique/edit.html.twig', array(
            'communeRubrique' => $communeRubrique,
            'communeRubriques' => $communeRubriques,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a communeRubrique entity.
     *
     * @Route("/{id}", name="backend_communerubrique_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CommuneRubrique $communeRubrique)
    {
        $form = $this->createDeleteForm($communeRubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($communeRubrique);
            $em->flush();
        }

        return $this->redirectToRoute('backend_communerubrique_index');
    }

    /**
     * Creates a form to delete a communeRubrique entity.
     *
     * @param CommuneRubrique $communeRubrique The communeRubrique entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommuneRubrique $communeRubrique)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_communerubrique_delete', array('id' => $communeRubrique->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
