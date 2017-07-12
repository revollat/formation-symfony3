<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Critique
 *
 * @ORM\Table(name="critique")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CritiqueRepository")
 */
class Critique
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="smallint")
     * @Assert\NotBlank()
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="avis", type="text")
     * @Assert\NotBlank()
     */
    private $avis;

    /**
     * @ORM\ManyToOne(targetEntity="Livre", inversedBy="critiques")
     * @ORM\JoinColumn(name="livre_id", referencedColumnName="id")
     */
    private $livre;
    
    public function __toString() {
        return $this->getEmail();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Critique
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Critique
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set avis
     *
     * @param string $avis
     *
     * @return Critique
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return string
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set livre
     *
     * @param \AppBundle\Entity\Livre $livre
     *
     * @return Critique
     */
    public function setLivre(\AppBundle\Entity\Livre $livre = null)
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * Get livre
     *
     * @return \AppBundle\Entity\Livre
     */
    public function getLivre()
    {
        return $this->livre;
    }
}
