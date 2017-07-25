<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Livre;
use AppBundle\Service\Citation;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, Citation $citation)
    {
        //$citation = $this->get(Citation::class); // On pourrais aussi récupérer le service via son ID (i.e. le nom de la classe automatiquement attibué à la compilation du DIC, cf. service.yml )
        return $this->render('default/index.html.twig',[
            'citation' => $citation->getCitation()
        ]);
    }
    
    


    /**
     * @Route("/livre/{slug}", name = "detail_livre")
     * @ParamConverter("livre", options={"mapping": {"slug": "slug"}})
     */
    public function detailLivreAction(Request $request, Livre $livre)
    {
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
