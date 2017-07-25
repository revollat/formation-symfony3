<?php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    
    private $remplacements;
    
    public function __construct($remplacements)
    {
        $this->remplacements = $remplacements;
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('lolcat', array($this, 'lolcatMe')),
        );
    }

    public function lolcatMe($text)
    {
        foreach($this->remplacements as $remplacement => $valeur){
            $text = mb_ereg_replace($remplacement, $valeur, $text);
        }
        return $text;
    }
}
