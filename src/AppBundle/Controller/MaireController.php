<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Maire;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Maire controller.
 *
 * @Route("backend/maire")
 */
class MaireController extends Controller
{
    /**
     * Lists all maire entities.
     *
     * @Route("/", name="backend_maire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $maires = $em->getRepository('AppBundle:Maire')->findAll();

        return $this->render('maire/index.html.twig', array(
            'maires' => $maires,
        ));
    }

    /**
     * Creates a new maire entity.
     *
     * @Route("/new", name="backend_maire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $maire = new Maire();
        $form = $this->createForm('AppBundle\Form\MaireType', $maire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($maire->getContenu(), 300, '...', true);
            $maire->setResume($resume);
            $em->persist($maire);
            $em->flush();

            return $this->redirectToRoute('backend_maire_show', array('slug' => $maire->getSlug()));
        }

        return $this->render('maire/new.html.twig', array(
            'maire' => $maire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a maire entity.
     *
     * @Route("/{slug}", name="backend_maire_show")
     * @Method("GET")
     */
    public function showAction(Maire $maire)
    {
        $deleteForm = $this->createDeleteForm($maire);

        return $this->render('maire/show.html.twig', array(
            'maire' => $maire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing maire entity.
     *
     * @Route("/{slug}/edit", name="backend_maire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Maire $maire, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($maire);
        $editForm = $this->createForm('AppBundle\Form\MaireType', $maire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($maire->getContenu(), 300, '...', true);
            $maire->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_maire_show', array('slug' => $maire->getSlug()));
        }

        return $this->render('maire/edit.html.twig', array(
            'maire' => $maire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a maire entity.
     *
     * @Route("/{id}", name="backend_maire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Maire $maire)
    {
        $form = $this->createDeleteForm($maire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($maire);
            $em->flush();
        }

        return $this->redirectToRoute('backend_maire_index');
    }

    /**
     * Creates a form to delete a maire entity.
     *
     * @param Maire $maire The maire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Maire $maire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_maire_delete', array('id' => $maire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
