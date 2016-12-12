<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxaState
 *
 * @ORM\Table(name="taxa_states", indexes={@ORM\Index(name="state_id", columns={"state_id"}), @ORM\Index(name="taxon_id", columns={"taxon_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\TaxaStateRepository")
 */
class TaxaState
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="taxa_states_id", type="integer", nullable=false)
     */
    private $taxaStatesId;

    /**
     * @var int
     *
     * @ORM\Column(name="taxon_id", type="integer")
     */
    private $taxonId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="state_id", type="integer")
     */
    private $stateId;

    /**
     * @var string
     *
     * @ORM\Column(name="low_value", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $lowValue;

    /**
     * @var string
     *
     * @ORM\Column(name="high_value", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $highValue;
    
    /**
     * @ORM\ManyToOne(targetEntity="Taxon", inversedBy="taxastates")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="taxa_id")
     */
    protected $taxon;

    /**
     * @ORM\ManyToOne(targetEntity="State", inversedBy="taxastates")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="states_id")
     */
    protected $state;
    
    public function getId()
    {
        return $this->taxaStatesId;
    }  
    
    public function getState()
    {
    	return $this->state;
    }
    
    public function getTaxonId()
    {
        return $this->taxonId;
    }
    
    public function getStateId()
    {
        return $this->stateId;
    }
    
    public function getLowValue()
    {
        return $this->lowValue;
    }
    
    public function getHighValue()
    {
        return $this->highValue;
    }
}

