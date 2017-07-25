<?php
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;

class Citation
{
    
    private $logger;
    
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function getCitation()
    {
        $messages = [
            "L’imagination est plus importante que le savoir",
            "Ils ne savaient pas que c’était impossible, alors ils l’ont fait",
            "Il n’existe rien de constant si ce n’est le changement."
        ];
        $index = array_rand($messages);
        
        $this->logger->info('Citation affichée : ' . $messages[$index]);
        
        return $messages[$index];
    }
}