<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Table(name="livre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LivreRepository")
 * @Vich\Uploadable
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
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=100, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    
    /**
     * NOTE: Ce champ n'est pas mappé dans doctrine c'est juste une propriété d'un objet livre
     * @Vich\UploadableField(mapping="livre_image", fileNameProperty="couverture")
     * @var File
     */
    private $couvertureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $couverture;
    
    /**
     * Un livre peut
     * @ORM\OneToMany(targetEntity="Critique", mappedBy="livre", cascade={"persist"})
     */
    private $critiques;
    

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

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

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Livre
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set couverture
     *
     * @param string $couverture
     *
     * @return Livre
     */
    public function setCouverture($couverture)
    {
        $this->couverture = $couverture;

        return $this;
    }

    /**
     * Get couverture
     *
     * @return string
     */
    public function getCouverture()
    {
        return $this->couverture;
    }
    
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Livre
     */
    public function setCouvertureFile(File $image = null)
    {
        $this->couvertureFile = $image;
        
        return $this;
    }

    /**
     * @return File|null
     */
    public function getCouvertureFile()
    {
        return $this->couvertureFile;
    }
    

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Livre
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Livre
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
