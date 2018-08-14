<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Agenda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
                                                           use AppBundle\Utils\Utilities;

/**
 * Agenda controller.
 *
 * @Route("backend/agenda")
 */
class AgendaController extends Controller
{
    /**
     * Lists all agenda entities.
     *
     * @Route("/", name="backend_agenda_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agendas = $em->getRepository('AppBundle:Agenda')->findAgendaDESC();

        return $this->render('agenda/index.html.twig', array(
            'agendas' => $agendas,
        ));
    }

    /**
     * Creates a new agenda entity.
     *
     * @Route("/new", name="backend_agenda_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $agenda = new Agenda();
        $form = $this->createForm('AppBundle\Form\AgendaType', $agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($agenda->getContenu(), 300, '...', true);
            $agenda->setResume($resume);
            $em->persist($agenda);
            $em->flush();

            return $this->redirectToRoute('backend_agenda_show', array('slug' => $agenda->getSlug()));
        }

        return $this->render('agenda/new.html.twig', array(
            'agenda' => $agenda,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a agenda entity.
     *
     * @Route("/{slug}", name="backend_agenda_show")
     * @Method("GET")
     */
    public function showAction(Agenda $agenda)
    {
        $deleteForm = $this->createDeleteForm($agenda);

        return $this->render('agenda/show.html.twig', array(
            'agenda' => $agenda,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing agenda entity.
     *
     * @Route("/{slug}/edit", name="backend_agenda_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Agenda $agenda, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($agenda);
        $editForm = $this->createForm('AppBundle\Form\AgendaType', $agenda);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($agenda->getContenu(), 300, '...', true);
            $agenda->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_agenda_show', array('slug' => $agenda->getSlug()));
        }

        return $this->render('agenda/edit.html.twig', array(
            'agenda' => $agenda,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a agenda entity.
     *
     * @Route("/{id}", name="backend_agenda_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Agenda $agenda)
    {
        $form = $this->createDeleteForm($agenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agenda);
            $em->flush();
        }

        return $this->redirectToRoute('backend_agenda_index');
    }

    /**
     * Creates a form to delete a agenda entity.
     *
     * @param Agenda $agenda The agenda entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Agenda $agenda)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_agenda_delete', array('id' => $agenda->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
