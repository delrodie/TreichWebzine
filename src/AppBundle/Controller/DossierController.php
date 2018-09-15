<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dossier;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Dossier controller.
 *
 * @Route("backend/dossier")
 */
class DossierController extends Controller
{
    /**
     * Lists all dossier entities.
     *
     * @Route("/", name="backend_dossier_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dossiers = $em->getRepository('AppBundle:Dossier')->findListDesc();

        return $this->render('dossier/index.html.twig', array(
            'dossiers' => $dossiers,
        ));
    }

    /**
     * Creates a new dossier entity.
     *
     * @Route("/new", name="backend_dossier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $dossier = new Dossier();
        $form = $this->createForm('AppBundle\Form\DossierType', $dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($dossier->getContenu(), 300, '...', true);
            $dossier->setResume($resume);
            $em->persist($dossier);
            $em->flush();

            return $this->redirectToRoute('backend_dossier_show', array('slug' => $dossier->getSlug()));
        }

        return $this->render('dossier/new.html.twig', array(
            'dossier' => $dossier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a dossier entity.
     *
     * @Route("/{slug}", name="backend_dossier_show")
     * @Method("GET")
     */
    public function showAction(Dossier $dossier)
    {
        $deleteForm = $this->createDeleteForm($dossier);

        return $this->render('dossier/show.html.twig', array(
            'dossier' => $dossier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing dossier entity.
     *
     * @Route("/{slug}/edit", name="backend_dossier_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dossier $dossier, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($dossier);
        $editForm = $this->createForm('AppBundle\Form\DossierType', $dossier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($dossier->getContenu(), 300, '...', true);
            $dossier->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_dossier_show', array('slug' => $dossier->getSlug()));
        }

        return $this->render('dossier/edit.html.twig', array(
            'dossier' => $dossier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a dossier entity.
     *
     * @Route("/{id}", name="backend_dossier_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dossier $dossier)
    {
        $form = $this->createDeleteForm($dossier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dossier);
            $em->flush();
        }

        return $this->redirectToRoute('backend_dossier_index');
    }

    /**
     * Creates a form to delete a dossier entity.
     *
     * @param Dossier $dossier The dossier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dossier $dossier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_dossier_delete', array('id' => $dossier->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
