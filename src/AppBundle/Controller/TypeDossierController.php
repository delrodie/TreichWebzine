<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeDossier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typedossier controller.
 *
 * @Route("backend/typedossier")
 */
class TypeDossierController extends Controller
{
    /**
     * Lists all typeDossier entities.
     *
     * @Route("/", name="backend_typedossier_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typeDossiers = $em->getRepository('AppBundle:TypeDossier')->findTypeDossierASC();
        $typeDossier = new Typedossier();
        $form = $this->createForm('AppBundle\Form\TypeDossierType', $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeDossier);
            $em->flush();

            return $this->redirectToRoute('backend_typedossier_index');
        }

        return $this->render('typedossier/index.html.twig', array(
            'typeDossiers' => $typeDossiers,
            'typeDossier' => $typeDossier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typeDossier entity.
     *
     * @Route("/new", name="backend_typedossier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeDossier = new Typedossier();
        $form = $this->createForm('AppBundle\Form\TypeDossierType', $typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeDossier);
            $em->flush();

            return $this->redirectToRoute('backend_typedossier_show', array('id' => $typeDossier->getId()));
        }

        return $this->render('typedossier/new.html.twig', array(
            'typeDossier' => $typeDossier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeDossier entity.
     *
     * @Route("/{id}", name="backend_typedossier_show")
     * @Method("GET")
     */
    public function showAction(TypeDossier $typeDossier)
    {
        $deleteForm = $this->createDeleteForm($typeDossier);

        return $this->render('typedossier/show.html.twig', array(
            'typeDossier' => $typeDossier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeDossier entity.
     *
     * @Route("/{slug}/edit", name="backend_typedossier_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeDossier $typeDossier)
    {
        $deleteForm = $this->createDeleteForm($typeDossier);
        $editForm = $this->createForm('AppBundle\Form\TypeDossierType', $typeDossier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typedossier_index');
        }
        $em = $this->getDoctrine()->getManager();

        $typeDossiers = $em->getRepository('AppBundle:TypeDossier')->findTypeDossierASC();

        return $this->render('typedossier/edit.html.twig', array(
            'typeDossier' => $typeDossier,
            'typeDossiers' => $typeDossiers,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeDossier entity.
     *
     * @Route("/{id}", name="backend_typedossier_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeDossier $typeDossier)
    {
        $form = $this->createDeleteForm($typeDossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeDossier);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typedossier_index');
    }

    /**
     * Creates a form to delete a typeDossier entity.
     *
     * @param TypeDossier $typeDossier The typeDossier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeDossier $typeDossier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typedossier_delete', array('id' => $typeDossier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
