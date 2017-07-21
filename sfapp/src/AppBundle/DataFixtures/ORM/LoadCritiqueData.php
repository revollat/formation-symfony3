<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Critique;
use Faker;

class LoadCritiqueData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Faker\Factory::create('fr_FR');
        
            
        for($i=1;$i<=10;$i++){
            
            $ref_livre = $this->getReference('livre'.$i); // Référence livre courant
            $nb_critiques = mt_rand(0, 3); // Entre 0 et 3 critiques
            
            while ($nb_critiques > 0) { // On insère entre 0 et 3 critiques
                $critique = new Critique();
                
                $critique->setEmail($faker->email());
                $critique->setNote(mt_rand(0, 5));
                $critique->setAvis($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
                $critique->setLivre($ref_livre);
                
                $manager->persist($critique);
                
                $nb_critiques--;
            }

        }
            
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 20;
    }
    
}