<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Character
 *
 * @ORM\Table(name="characters")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\CharacterRepository")
 */
class Character
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
     * @var bool
     *
     * @ORM\Column(name="is_numeric", type="boolean")
     */
    private $isNumeric;

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer", nullable=true)
     */
    private $typeId;
   
    
    /**
     * @ORM\OneToMany(targetEntity="State", mappedBy="character")
     */
    protected $states;

    /**
     * @ORM\ManyToOne(targetEntity="Charactertype", inversedBy="characters")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;
    
    /**
     * Cross DB Entity
     * @var \AppBundle\Entity\VirtualViburnum\Character
     */
    protected $character;
    
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->states = new ArrayCollection();
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
     * Set isNumeric
     *
     * @param boolean $isNumeric
     *
     * @return Character
     */
    public function setIsNumeric($isNumeric)
    {
        $this->isNumeric = $isNumeric;

        return $this;
    }

    /**
     * Get isNumeric
     *
     * @return bool
     */
    public function getIsNumeric()
    {
        return $this->isNumeric;
    }

    /**
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return Character
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\State $state
     * @return \AppBundle\Entity\iCViburnum\CHaracter
     */
    public function addState(\AppBundle\Entity\iCViburnum\State $state)
    {
        $state->setCharacter($this);
        $this->states->add($state);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStates()
    {
        return $this->states;
    }
    
    /**
     * 
     * @param \AppBundle\Entity\iCViburnum\Charactertype $type
     * @return \AppBundle\Entity\iCViburnum\Character
     */
    public function setType($type)
    {
    	$this->type = $type;
    	 
    	return $this;
    }
    
    /**
     * return \AppBundle\Entity\iCViburnum\Character
     */
    public function getType()
    {
    	return $this->type;
    }
    
    /**
     * @return \AppBundle\Entity\VirtualViburnum\Character
     */
    public function getCharacter()
    {
        // Need to call getId so that the object is loaded
        $this->character->getId();
        return $this->character;
    }
}

