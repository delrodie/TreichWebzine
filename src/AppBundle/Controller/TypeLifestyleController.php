<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeLifestyle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typelifestyle controller.
 *
 * @Route("backend/typelifestyle")
 */
class TypeLifestyleController extends Controller
{
    /**
     * Lists all typeLifestyle entities.
     *
     * @Route("/", name="backend_typelifestyle_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typeLifestyles = $em->getRepository('AppBundle:TypeLifestyle')->findAllAsc();
        $typeLifestyle = new Typelifestyle();
        $form = $this->createForm('AppBundle\Form\TypeLifestyleType', $typeLifestyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeLifestyle);
            $em->flush();

            return $this->redirectToRoute('backend_typelifestyle_index');
        }

        return $this->render('typelifestyle/index.html.twig', array(
            'typeLifestyles' => $typeLifestyles,
            'typeLifestyle' => $typeLifestyle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typeLifestyle entity.
     *
     * @Route("/new", name="backend_typelifestyle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeLifestyle = new Typelifestyle();
        $form = $this->createForm('AppBundle\Form\TypeLifestyleType', $typeLifestyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeLifestyle);
            $em->flush();

            return $this->redirectToRoute('backend_typelifestyle_show', array('id' => $typeLifestyle->getId()));
        }

        return $this->render('typelifestyle/new.html.twig', array(
            'typeLifestyle' => $typeLifestyle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeLifestyle entity.
     *
     * @Route("/{id}", name="backend_typelifestyle_show")
     * @Method("GET")
     */
    public function showAction(TypeLifestyle $typeLifestyle)
    {
        $deleteForm = $this->createDeleteForm($typeLifestyle);

        return $this->render('typelifestyle/show.html.twig', array(
            'typeLifestyle' => $typeLifestyle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeLifestyle entity.
     *
     * @Route("/{slug}/edit", name="backend_typelifestyle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeLifestyle $typeLifestyle)
    {
        $em = $this->getDoctrine()->getManager();

        $typeLifestyles = $em->getRepository('AppBundle:TypeLifestyle')->findAllAsc();
        $deleteForm = $this->createDeleteForm($typeLifestyle);
        $editForm = $this->createForm('AppBundle\Form\TypeLifestyleType', $typeLifestyle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typelifestyle_index');
        }

        return $this->render('typelifestyle/edit.html.twig', array(
            'typeLifestyle' => $typeLifestyle,
            'typeLifestyles' => $typeLifestyles,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeLifestyle entity.
     *
     * @Route("/{id}", name="backend_typelifestyle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeLifestyle $typeLifestyle)
    {
        $form = $this->createDeleteForm($typeLifestyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeLifestyle);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typelifestyle_index');
    }

    /**
     * Creates a form to delete a typeLifestyle entity.
     *
     * @param TypeLifestyle $typeLifestyle The typeLifestyle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeLifestyle $typeLifestyle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typelifestyle_delete', array('id' => $typeLifestyle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
