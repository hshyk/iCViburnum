<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Character
 *
 * @ORM\Table(name="characters", indexes={@ORM\Index(name="characters_id", columns={"characters_id"}), @ORM\Index(name="character_type_id", columns={"character_type_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\CharacterRepository")
 */
class Character
{
    /**
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(name="characters_id", type="integer", nullable=false)
     */
    private $charactersId;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="character_name", type="string", length=255, nullable=false)
     */
    private $characterName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_numeric", type="boolean", nullable=false)
     */
    private $isNumeric;
    
    /**
     * @var int
     *
     * @ORM\Column(name="character_type_id", type="integer")
     */
    private $characterTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="sort_sequence", type="string", length=2, nullable=false)
     */
    private $sortSequence;

    /**
     * @var \CharacterTypes
     *
     * @ORM\ManyToOne(targetEntity="CharacterType")
     * @ORM\JoinColumn(name="character_type_id", referencedColumnName="character_types_id")
     */
    protected $characterType;
    
    /**
     * @ORM\OneToMany(targetEntity="State", mappedBy="character")
     */
    protected $states;
    
    
    /**
     * Get character_id
     *
     * @return int
     */
    public function getId()
    {
    	return $this->charactersId;
    }
    
    public function getIsNumeric()
    {
        return $this->isNumeric;
    }
    
    public function getCharacterName()
    {
    	return $this->characterName;
    }
    
    public function getCharacterTypeId()
    {
        return $this->characterTypeId;
    }
    
    public function getCharacterType()
    {
    	return $this->characterType;
    }
    
    public function getStates()
    {
    	return $this->states;
    }
    

}

