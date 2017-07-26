<?php
namespace AppBundle\EventListener;

use AppBundle\Event\LivreVuEvent;

class MailOnLivreVu
{

  protected $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
      $this->mailer = $mailer;
  }


  public function envoiMail(LivreVuEvent $event)
  {
      $livre = $event->getLivre();
      
      $message = \Swift_Message::newInstance()
        ->setSubject('Livre vu')
        ->setFrom('admin@example.com')
        ->setTo('admin@example.com')
        ->addPart("Quelqu'un a visité la page du livre :  ". $livre->getTitre())
      ;
      
      $this->mailer->send($message);

  }

}