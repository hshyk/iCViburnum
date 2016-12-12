<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Charactertype
 *
 * @ORM\Table(name="charactertypes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\CharactertypeRepository")
 */
class Charactertype
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="type")
     */
    protected $characters;
    

    /**
     * Initialize relationships
     */
    public function __construct() {
    	$this->characters = new ArrayCollection();
    }
    
    /**
     * Set the id
     * 
     * @param int
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * 
     * @param \AppBundle\Entity\iCViburnum\Character $character
     * @return \AppBundle\Entity\iCViburnum\Charactertype
     */
    public function addCharacter(\AppBundle\Entity\iCViburnum\Character $character)
    {
        $character->setType($this);
        $this->characters->add($character);
         
        return $this;
    }
    
    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCharacters()
    {
    	return $this->characters;
    }
}
