<?php

namespace AppBundle\Service;

class Citation
{
    public function getCitation()
    {
        $messages = [
            "L’imagination est plus importante que le savoir",
            "Ils ne savaient pas que c’était impossible, alors ils l’ont fait",
            "Il n’existe rien de constant si ce n’est le changement."
        ];
        $index = array_rand($messages);
        return $messages[$index];
    }
}