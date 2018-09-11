<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeevent controller.
 *
 * @Route("backend/typeevent")
 */
class TypeEventController extends Controller
{
    /**
     * Lists all typeEvent entities.
     *
     * @Route("/", name="backend_typeevent_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typeEvents = $em->getRepository('AppBundle:TypeEvent')->findTypeEventASC();
        
        $typeEvent = new Typeevent();
        $form = $this->createForm('AppBundle\Form\TypeEventType', $typeEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeEvent);
            $em->flush();

            return $this->redirectToRoute('backend_typeevent_index');
        }

        return $this->render('typeevent/index.html.twig', array(
            'typeEvents' => $typeEvents,
            'typeEvent' => $typeEvent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typeEvent entity.
     *
     * @Route("/new", name="backend_typeevent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeEvent = new Typeevent();
        $form = $this->createForm('AppBundle\Form\TypeEventType', $typeEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeEvent);
            $em->flush();

            return $this->redirectToRoute('backend_typeevent_show', array('id' => $typeEvent->getId()));
        }

        return $this->render('typeevent/new.html.twig', array(
            'typeEvent' => $typeEvent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeEvent entity.
     *
     * @Route("/{id}", name="backend_typeevent_show")
     * @Method("GET")
     */
    public function showAction(TypeEvent $typeEvent)
    {
        $deleteForm = $this->createDeleteForm($typeEvent);

        return $this->render('typeevent/show.html.twig', array(
            'typeEvent' => $typeEvent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeEvent entity.
     *
     * @Route("/{slug}/edit", name="backend_typeevent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeEvent $typeEvent)
    {
        $em = $this->getDoctrine()->getManager();

        $typeEvents = $em->getRepository('AppBundle:TypeEvent')->findAll();

        $deleteForm = $this->createDeleteForm($typeEvent);
        $editForm = $this->createForm('AppBundle\Form\TypeEventType', $typeEvent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typeevent_index');
        }

        return $this->render('typeevent/edit.html.twig', array(
            'typeEvent' => $typeEvent,
            'typeEvents' => $typeEvents,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeEvent entity.
     *
     * @Route("/{id}", name="backend_typeevent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeEvent $typeEvent)
    {
        $form = $this->createDeleteForm($typeEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeEvent);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typeevent_index');
    }

    /**
     * Creates a form to delete a typeEvent entity.
     *
     * @param TypeEvent $typeEvent The typeEvent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeEvent $typeEvent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typeevent_delete', array('id' => $typeEvent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
