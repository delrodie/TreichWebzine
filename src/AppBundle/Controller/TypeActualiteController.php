<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeActualite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeactualite controller.
 *
 * @Route("backend/typeactualite")
 */
class TypeActualiteController extends Controller
{
    /**
     * Lists all typeActualite entities.
     *
     * @Route("/", name="backend_typeactualite_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typeActualites = $em->getRepository('AppBundle:TypeActualite')
                                ->findTypeActualiteDESC()->getQuery()->getResult();

        $typeActualite = new Typeactualite();
        $form = $this->createForm('AppBundle\Form\TypeActualiteType', $typeActualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeActualite);
            $em->flush();

            return $this->redirectToRoute('backend_typeactualite_index');
        }

        return $this->render('typeactualite/index.html.twig', array(
            'typeActualites' => $typeActualites,
            'typeActualite' => $typeActualite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typeActualite entity.
     *
     * @Route("/new", name="backend_typeactualite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeActualite = new Typeactualite();
        $form = $this->createForm('AppBundle\Form\TypeActualiteType', $typeActualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeActualite);
            $em->flush();

            return $this->redirectToRoute('backend_typeactualite_show', array('id' => $typeActualite->getId()));
        }

        return $this->render('typeactualite/new.html.twig', array(
            'typeActualite' => $typeActualite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeActualite entity.
     *
     * @Route("/{id}", name="backend_typeactualite_show")
     * @Method("GET")
     */
    public function showAction(TypeActualite $typeActualite)
    {
        $deleteForm = $this->createDeleteForm($typeActualite);

        return $this->render('typeactualite/show.html.twig', array(
            'typeActualite' => $typeActualite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeActualite entity.
     *
     * @Route("/{slug}/edit", name="backend_typeactualite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeActualite $typeActualite)
    {
        $em = $this->getDoctrine()->getManager();

        $typeActualites = $em->getRepository('AppBundle:TypeActualite')
                                ->findTypeActualiteDESC()->getQuery()->getResult();

        $deleteForm = $this->createDeleteForm($typeActualite);
        $editForm = $this->createForm('AppBundle\Form\TypeActualiteType', $typeActualite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typeactualite_index');
        }

        return $this->render('typeactualite/edit.html.twig', array(
            'typeActualite' => $typeActualite,
            'typeActualites' => $typeActualites,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeActualite entity.
     *
     * @Route("/{id}", name="backend_typeactualite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeActualite $typeActualite)
    {
        $form = $this->createDeleteForm($typeActualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeActualite);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typeactualite_index');
    }

    /**
     * Creates a form to delete a typeActualite entity.
     *
     * @param TypeActualite $typeActualite The typeActualite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeActualite $typeActualite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typeactualite_delete', array('id' => $typeActualite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
