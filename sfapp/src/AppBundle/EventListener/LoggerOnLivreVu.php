<?php
namespace AppBundle\EventListener;

use AppBundle\Event\LivreVuEvent;
use Psr\Log\LoggerInterface;

class LoggerOnLivreVu
{

  protected $logger;

  public function __construct(LoggerInterface $logger)
  {
      $this->logger = $logger;
  }


  public function process(LivreVuEvent $event)
  {
      $livre = $event->getLivre();
      $this->logger->info("Le livre '" . $livre->getTitre() . "' a été vu !");
  }

}