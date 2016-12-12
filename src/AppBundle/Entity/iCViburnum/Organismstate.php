<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organismstate
 *
 * @ORM\Table(name="organismstates")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\OrganismstateRepository")
 */
class Organismstate
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
     * @ORM\Column(name="organism_id", type="integer")
     */
    private $organismId;

    /**
     * @var int
     *
     * @ORM\Column(name="state_id", type="integer")
     */
    private $stateId;

    /**
     * @var float
     *
     * @ORM\Column(name="low_value", type="float", nullable=true)
     */
    private $lowValue;

    /**
     * @var float
     *
     * @ORM\Column(name="high_value", type="float", nullable=true)
     */
    private $highValue;
    
    /**
     * @ORM\ManyToOne(targetEntity="Organism", inversedBy="states")
     * @ORM\JoinColumn(name="organism_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $organism;
    
    /**
     * @ORM\ManyToOne(targetEntity="State", inversedBy="organisms")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $state;   


    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set organismId
     *
     * @param integer $organismId
     *
     * @return Organismstate
     */
    public function setOrganismId($organismId)
    {
        $this->organismId = $organismId;

        return $this;
    }

    /**
     * Get organismId
     *
     * @return int
     */
    public function getOrganismId()
    {
        return $this->organismId;
    }

    /**
     * Set stateId
     *
     * @param integer $stateId
     *
     * @return Organismstate
     */
    public function setStateId($stateId)
    {
        $this->stateId = $stateId;

        return $this;
    }

    /**
     * Get stateId
     *
     * @return int
     */
    public function getStateId()
    {
        return $this->stateId;
    }

    /**
     * Set lowValue
     *
     * @param float $lowValue
     *
     * @return Organismstate
     */
    public function setLowValue($lowValue)
    {
        $this->lowValue = $lowValue;

        return $this;
    }

    /**
     * Get lowValue
     *
     * @return float
     */
    public function getLowValue()
    {
        return $this->lowValue;
    }

    /**
     * Set highValue
     *
     * @param float $highValue
     *
     * @return Organismstate
     */
    public function setHighValue($highValue)
    {
        $this->highValue = $highValue;

        return $this;
    }

    /**
     * Get highValue
     *
     * @return float
     */
    public function getHighValue()
    {
        return $this->highValue;
    }
    
    /**
     * Set the organism
     *
     * @param \AppBundle\Entity\iCViburnum\Organism $organism
     * @return \AppBundle\Entity\iCViburnum\Observation
     */
    public function setOrganism($organism)
    {
        $this->organism = $organism;
    
        return $this;
    }
     
    /**
     * Get the organism
     *
     * @return \AppBundle\Entity\iCViburnum\Organism
     */
    public function getOrganism()
    {
        return $this->organism;
    }
    
    
    /**
     * Set the state
     *
     * @param \AppBundle\Entity\iCViburnum\State $state
     * @return \AppBundle\Entity\iCViburnum\Organismstate
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }
     
    /**
     * Get the state
     *
     * @return \AppBundle\Entity\iCViburnum\State
     */
    public function getState()
    {
        return $this->state;
    }
}
