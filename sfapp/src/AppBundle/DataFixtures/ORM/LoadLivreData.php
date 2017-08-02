<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Livre;
use Faker;

class LoadLivreData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Faker\Factory::create('fr_FR');
        
        for($i=1;$i<=10;$i++){
            
            $date_courante = new \DateTime();
            
            $livre = new Livre();
            
            $livre->setTitre($faker->sentence($nbWords = 3, $variableNbWords = true));
            $livre->setDescription($faker->text($maxNbChars = 500));
            $livre->setCreated($date_courante);
            $livre->setUpdated($date_courante);
            $this->addReference('livre' . $i , $livre);
             
            $manager->persist($livre);
            
        }
            
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 10;
    }
    
}