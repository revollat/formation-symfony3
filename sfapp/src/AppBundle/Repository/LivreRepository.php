<?php
namespace AppBundle\Repository;
class LivreRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function getLivresAccueil($max=3)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT l FROM AppBundle:Livre l ORDER BY l.titre ASC'
            )
            ->setMaxResults($max)
            ->getResult()
        ;

    }
    
}
