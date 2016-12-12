<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CharacterType
 *
 * @ORM\Table(name="character_types")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\CharacterTypeRepository")
 */
class CharacterType
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="character_types_id", type="integer", nullable=false)
     */
    private $characterTypesId;

    /**
     * @var string
     *
     * @ORM\Column(name="character_type", type="string", length=255, nullable=false)
     */
    private $characterType;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort_sequence", type="integer", nullable=false)
     */
    private $sortSequence;
    
    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="characterType")
     * @ORM\OrderBy({"characterName" = "ASC"})
     */
    protected $characters;
    
    /**
     * Initialize relationships
     */
    public function __construct() {
    	$this->characters = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
    	return $this->characterTypesId;
    }
    

    public function getCharacterType()
    {
    	return $this->characterType;
    }
    
    public function getCharacters()
    {
    	return $this->characters;
    }


}

