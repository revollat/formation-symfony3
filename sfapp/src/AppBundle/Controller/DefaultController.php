<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Livre;
use AppBundle\Service\NotificationAffichageCitation;
use AppBundle\Event\LivreVuEvent;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, NotificationAffichageCitation $notif)
    {
        return $this->render('default/index.html.twig',[
            'citation' => $notif->notification()
        ]);
    }

    /**
     * @Route("/livre/{slug}", name = "detail_livre")
     * @ParamConverter("livre", options={"mapping": {"slug": "slug"}})
     */
    public function detailLivreAction(Request $request, Livre $livre)
    {
        
        $event = new LivreVuEvent($livre);
        $this->get('event_dispatcher')->dispatch(LivreVuEvent::NAME, $event);
        
        return $this->render('default/detail_livre.html.twig', [
            'livre' => $livre
        ]);
        
    }
    
    /**
     * @Route("/get-critiques/{slug}", name = "get_json_critiques_pour_livre")
     * @ParamConverter("livre", options={"mapping": {"slug": "slug"}})
     */
    public function getJsonCritiquesPourLivre(Request $request, Livre $livre)
    {
        $critiques = $livre->getCritiques();
        // foreach ($critiques as $critique){
        //     $this->get('serializer')->serialize($critique, 'json');
        // }
        
        return $this->json($critiques);
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        
        $form = $this->createForm(ContactType::class);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            
            $message = (new \Swift_Message($data['sujet']))
                ->setFrom($data['email'])
                ->setTo('contact@example.com')
                ->setBody(
                    $this->render('default/mail.html.twig', [
                        'message' => $data['message']
                    ]) 
                )
                ->setContentType("text/html")
            ;
                
            $mailer->send($message);
            
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
