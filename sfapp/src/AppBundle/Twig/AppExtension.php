<?php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('lolcat', array($this, 'lolcatMe')),
        );
    }

    public function lolcatMe($text)
    {
        return mb_ereg_replace("chat", "🐱", $text);
    }
}
