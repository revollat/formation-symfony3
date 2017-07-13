<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="livre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LivreRepository")
 */
class Livre
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    /**
     * Un livre peut
     * @ORM\OneToMany(targetEntity="Critique", mappedBy="livre", cascade={"persist"})
     */
    private $critiques;

    public function __construct() {
        $this->critiques = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->getTitre();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Livre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Livre
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add critique
     *
     * @param \AppBundle\Entity\Critique $critique
     *
     * @return Livre
     */
    public function addCritique(\AppBundle\Entity\Critique $critique)
    {
        $this->critiques[] = $critique;
        
        $critique->setLivre($this);

        return $this;
    }

    /**
     * Remove critique
     *
     * @param \AppBundle\Entity\Critique $critique
     */
    public function removeCritique(\AppBundle\Entity\Critique $critique)
    {
        $this->critiques->removeElement($critique);
    }

    /**
     * Get critiques
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCritiques()
    {
        return $this->critiques;
    }
}
