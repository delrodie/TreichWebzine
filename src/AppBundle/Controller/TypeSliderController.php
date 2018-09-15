<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TypeSlider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeslider controller.
 *
 * @Route("backend/typeslider")
 */
class TypeSliderController extends Controller
{
    /**
     * Lists all typeSlider entities.
     *
     * @Route("/", name="backend_typeslider_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typeSliders = $em->getRepository('AppBundle:TypeSlider')->findAllAsc();
        $typeSlider = new Typeslider();
        $form = $this->createForm('AppBundle\Form\TypeSliderType', $typeSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeSlider);
            $em->flush();

            return $this->redirectToRoute('backend_typeslider_index');
        }

        return $this->render('typeslider/index.html.twig', array(
            'typeSliders' => $typeSliders,
            'typeSlider' => $typeSlider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typeSlider entity.
     *
     * @Route("/new", name="backend_typeslider_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeSlider = new Typeslider();
        $form = $this->createForm('AppBundle\Form\TypeSliderType', $typeSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeSlider);
            $em->flush();

            return $this->redirectToRoute('backend_typeslider_show', array('id' => $typeSlider->getId()));
        }

        return $this->render('typeslider/new.html.twig', array(
            'typeSlider' => $typeSlider,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeSlider entity.
     *
     * @Route("/{id}", name="backend_typeslider_show")
     * @Method("GET")
     */
    public function showAction(TypeSlider $typeSlider)
    {
        $deleteForm = $this->createDeleteForm($typeSlider);

        return $this->render('typeslider/show.html.twig', array(
            'typeSlider' => $typeSlider,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeSlider entity.
     *
     * @Route("/{slug}/edit", name="backend_typeslider_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeSlider $typeSlider)
    {
        $deleteForm = $this->createDeleteForm($typeSlider);
        $editForm = $this->createForm('AppBundle\Form\TypeSliderType', $typeSlider);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typeslider_index');
        }
        $em = $this->getDoctrine()->getManager();

        $typeSliders = $em->getRepository('AppBundle:TypeSlider')->findAllAsc();

        return $this->render('typeslider/edit.html.twig', array(
            'typeSlider' => $typeSlider,
            'typeSliders' => $typeSliders,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeSlider entity.
     *
     * @Route("/{id}", name="backend_typeslider_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeSlider $typeSlider)
    {
        $form = $this->createDeleteForm($typeSlider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeSlider);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typeslider_index');
    }

    /**
     * Creates a form to delete a typeSlider entity.
     *
     * @param TypeSlider $typeSlider The typeSlider entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeSlider $typeSlider)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typeslider_delete', array('id' => $typeSlider->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
