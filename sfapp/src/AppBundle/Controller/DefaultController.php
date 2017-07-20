<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->addFlash(
                'notice',
                'Message envoyé à ' . $data['email']
            );
        
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    public function livresAccueilAction($max = 3)
    {
        
        $em = $this->getDoctrine()->getManager();
        $livres = $em->getRepository('AppBundle:Livre')->getLivresAccueil($max);
        return $this->render('default/_livres_accueil.html.twig', [
            'livres' => $livres
        ]);
    }
    
}
