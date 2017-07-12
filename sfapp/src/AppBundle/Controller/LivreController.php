<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Livre controller.
 *
 * @Route("livre_admin")
 */
class LivreController extends Controller
{
    /**
     * Lists all livre entities.
     *
     * @Route("/", name="livre_admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livres = $em->getRepository('AppBundle:Livre')->findAll();

        return $this->render('livre/index.html.twig', array(
            'livres' => $livres,
        ));
    }

    /**
     * Creates a new livre entity.
     *
     * @Route("/new", name="livre_admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm('AppBundle\Form\LivreType', $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('livre_admin_show', array('id' => $livre->getId()));
        }

        return $this->render('livre/new.html.twig', array(
            'livre' => $livre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a livre entity.
     *
     * @Route("/{id}", name="livre_admin_show")
     * @Method("GET")
     */
    public function showAction(Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);

        return $this->render('livre/show.html.twig', array(
            'livre' => $livre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing livre entity.
     *
     * @Route("/{id}/edit", name="livre_admin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);
        $editForm = $this->createForm('AppBundle\Form\LivreType', $livre);
        $editForm->handleRequest($request);

        // $originalCritiques = new ArrayCollection();
        // foreach ($livre->getCritiques() as $critique) {
        //     $originalCritiques->add($critique);
        // }
    
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            

            // foreach ($originalCritiques as $critique) {
            //     if (false === $livre->getCritiques()->contains($critique)) {
            //         $critique->getLivres()->removeElement($livre);
            //         $this->getDoctrine()->getManager()->persist($critique);
            //         $this->getDoctrine()->getManager()->remove($critique);
            //     }
            // }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_admin_edit', array('id' => $livre->getId()));
        }

        return $this->render('livre/edit.html.twig', array(
            'livre' => $livre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a livre entity.
     *
     * @Route("/{id}", name="livre_admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Livre $livre)
    {
        $form = $this->createDeleteForm($livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($livre);
            $em->flush();
        }

        return $this->redirectToRoute('livre_admin_index');
    }

    /**
     * Creates a form to delete a livre entity.
     *
     * @param Livre $livre The livre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Livre $livre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('livre_admin_delete', array('id' => $livre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
