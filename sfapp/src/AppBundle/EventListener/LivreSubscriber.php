<?php
namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
// for Doctrine < 2.4: use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
#use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\Livre;

class LivreSubscriber implements EventSubscriber
{
    
    protected $mailer;
    
    public function __construct(\Swift_Mailer $mailer)
    {
      $this->mailer = $mailer;
    }
  
    public function getSubscribedEvents()
    {
        // Liste des evenements possibles :
        // http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/events.html#lifecycle-events
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $livre = $this->isALivre($args);
        if(!$livre) return;
            
        $message = \Swift_Message::newInstance()
            ->setSubject("Post update d'un livre")
            ->setFrom('admin@example.com')
            ->setTo('admin@example.com')
            ->addPart("Le livre '". $livre->getTitre(). "' a été mis à jour.")
        ;
        
        $this->mailer->send($message);
        
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $livre = $this->isALivre($args);
        if(!$livre) return;
        
        $message = \Swift_Message::newInstance()
            ->setSubject("Post persist d'un livre")
            ->setFrom('admin@example.com')
            ->setTo('admin@example.com')
            ->addPart("Le livre '". $livre->getTitre(). "' a été ajouté.")
        ;
        
        $this->mailer->send($message);
        
    }

    public function isALivre(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Livre) {
            //$entityManager = $args->getEntityManager();
            return $entity;
        }else{
            return null;
        }
    }
}
