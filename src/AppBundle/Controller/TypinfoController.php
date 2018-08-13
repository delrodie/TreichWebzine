<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typinfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typinfo controller.
 *
 * @Route("backend/typinfo")
 */
class TypinfoController extends Controller
{
    /**
     * Lists all typinfo entities.
     *
     * @Route("/", name="backend_typinfo_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $typinfos = $em->getRepository('AppBundle:Typinfo')
                        ->findTypinfoDESC()->getQuery()->getResult()
                        ;
        
        $typinfo = new Typinfo();
        $form = $this->createForm('AppBundle\Form\TypinfoType', $typinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typinfo);
            $em->flush();

            return $this->redirectToRoute('backend_typinfo_index');
        }

        return $this->render('typinfo/index.html.twig', array(
            'typinfos' => $typinfos,
            'typinfo' => $typinfo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new typinfo entity.
     *
     * @Route("/new", name="backend_typinfo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typinfo = new Typinfo();
        $form = $this->createForm('AppBundle\Form\TypinfoType', $typinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typinfo);
            $em->flush();

            return $this->redirectToRoute('backend_typinfo_show', array('id' => $typinfo->getId()));
        }

        return $this->render('typinfo/new.html.twig', array(
            'typinfo' => $typinfo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typinfo entity.
     *
     * @Route("/{id}", name="backend_typinfo_show")
     * @Method("GET")
     */
    public function showAction(Typinfo $typinfo)
    {
        $deleteForm = $this->createDeleteForm($typinfo);

        return $this->render('typinfo/show.html.twig', array(
            'typinfo' => $typinfo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typinfo entity.
     *
     * @Route("/{slug}/edit", name="backend_typinfo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typinfo $typinfo)
    {
        $em = $this->getDoctrine()->getManager();

        $typinfos = $em->getRepository('AppBundle:Typinfo')
                        ->findTypinfoDESC()->getQuery()->getResult();

        $deleteForm = $this->createDeleteForm($typinfo);
        $editForm = $this->createForm('AppBundle\Form\TypinfoType', $typinfo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_typinfo_index');
        }

        return $this->render('typinfo/edit.html.twig', array(
            'typinfo' => $typinfo,
            'typinfos' => $typinfos,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typinfo entity.
     *
     * @Route("/{id}", name="backend_typinfo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typinfo $typinfo)
    {
        $form = $this->createDeleteForm($typinfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typinfo);
            $em->flush();
        }

        return $this->redirectToRoute('backend_typinfo_index');
    }

    /**
     * Creates a form to delete a typinfo entity.
     *
     * @param Typinfo $typinfo The typinfo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typinfo $typinfo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_typinfo_delete', array('id' => $typinfo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
