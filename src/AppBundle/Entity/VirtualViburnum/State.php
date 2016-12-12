<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="states", indexes={@ORM\Index(name="character_id", columns={"character_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\StateRepository")
 */
class State
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="states_id", type="integer", nullable=false)
     */
    private $statesId;

    /**
     * @var string
     *
     * @ORM\Column(name="state_name", type="string", length=255, nullable=false)
     */
    private $stateName;
    
    /**
     * @var int
     *
     * @ORM\Column(name="character_id", type="integer")
     */
    private $characterId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="definition", type="string", length=1025, nullable=false)
     */
    private $definition;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;
    
    /**
     * @var string
     *
     * @ORM\Column(name="credit", type="string", length=255, nullable=false)
     */
    private $credit;

    /**
     * @var \Character
     *
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="characters_id")
     */
    protected $character;
    
    /**
     * @ORM\OneToMany(targetEntity="TaxaState", mappedBy="state")
     */
    protected $taxastates;
    
    public function getId()
    {
    	return $this->statesId;
    }
    
    public function getCharacterId()
    {
        return $this->characterId;
    }
    
    public function getStateName()
    {
    	return $this->stateName;
    }
    
    public function getCharacter()
    {
    	return $this->character;
    }
    
    public function getDefinition()
    {
        return $this->definition;
    }
    public function getURL()
    {
        return $this->url;
    }
    public function getCredit()
    {
        return $this->credit;
    }


}

