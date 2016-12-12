<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="states")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\StateRepository")
 */
class State
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
     * @var int
     *
     * @ORM\Column(name="character_id", type="integer")
     */
    private $characterId;
    
    /**
     * @ORM\OneToMany(targetEntity="Organismstate", mappedBy="state")
     */
    protected $organisms;   
    
    /**
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="states")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $character;


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
     * Set characterId
     *
     * @param integer $characterId
     *
     * @return State
     */
    public function setCharacterId($characterId)
    {
        $this->characterId = $characterId;

        return $this;
    }

    /**
     * Get characterId
     *
     * @return int
     */
    public function getCharacterId()
    {
        return $this->characterId;
    }
    
    /**
     * Set isNumeric
     *
     * @param boolean $isNumeric
     *
     * @return State
     */
    public function setIsNumeric($isNumeric)
    {
        $this->isNumeric = $isNumeric;
    
        return $this;
    }

    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Organismstate $organism
     * @return \AppBundle\Entity\iCViburnum\State
     */
    public function addOrganism(\AppBundle\Entity\iCViburnum\Organismstate $organism)
    {
        $organism->addState($this);
        $this->organisms->add($organism);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrganisms()
    {
        return $this->organisms;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Character $character
     * @return \AppBundle\Entity\iCViburnum\Note
     */
    public function setCharacter($character)
    {
        $this->character = $character;
    
        return $this;
    }
    
    /**
     * return \AppBundle\Entity\iCViburnum\Character
     */
    public function getCharacter()
    {
        return $this->character;
    }
    
    
}
