<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lifestyle;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Lifestyle controller.
 *
 * @Route("backend/lifestyle")
 */
class LifestyleController extends Controller
{
    /**
     * Lists all lifestyle entities.
     *
     * @Route("/", name="backend_lifestyle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lifestyles = $em->getRepository('AppBundle:Lifestyle')->findAllDesc();

        return $this->render('lifestyle/index.html.twig', array(
            'lifestyles' => $lifestyles,
        ));
    }

    /**
     * Creates a new lifestyle entity.
     *
     * @Route("/new", name="backend_lifestyle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $lifestyle = new Lifestyle();
        $form = $this->createForm('AppBundle\Form\LifestyleType', $lifestyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($lifestyle->getContenu(), 300, '...', true);
            $lifestyle->setResume($resume);
            $em->persist($lifestyle);
            $em->flush();

            return $this->redirectToRoute('backend_lifestyle_show', array('slug' => $lifestyle->getSlug()));
        }

        return $this->render('lifestyle/new.html.twig', array(
            'lifestyle' => $lifestyle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a lifestyle entity.
     *
     * @Route("/{slug}", name="backend_lifestyle_show")
     * @Method("GET")
     */
    public function showAction(Lifestyle $lifestyle)
    {
        $deleteForm = $this->createDeleteForm($lifestyle);

        return $this->render('lifestyle/show.html.twig', array(
            'lifestyle' => $lifestyle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing lifestyle entity.
     *
     * @Route("/{slug}/edit", name="backend_lifestyle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lifestyle $lifestyle, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($lifestyle);
        $editForm = $this->createForm('AppBundle\Form\LifestyleType', $lifestyle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($lifestyle->getContenu(), 300, '...', true);
            $lifestyle->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_lifestyle_edit', array('id' => $lifestyle->getId()));
        }

        return $this->render('lifestyle/edit.html.twig', array(
            'lifestyle' => $lifestyle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a lifestyle entity.
     *
     * @Route("/{id}", name="backend_lifestyle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lifestyle $lifestyle)
    {
        $form = $this->createDeleteForm($lifestyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lifestyle);
            $em->flush();
        }

        return $this->redirectToRoute('backend_lifestyle_index');
    }

    /**
     * Creates a form to delete a lifestyle entity.
     *
     * @param Lifestyle $lifestyle The lifestyle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lifestyle $lifestyle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_lifestyle_delete', array('id' => $lifestyle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
