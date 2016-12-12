<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Observationtype
 *
 * @ORM\Table(name="observationtypes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ObservationtypeRepository")
 */
class Observationtype
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
     * @ORM\OneToMany(targetEntity="Observation", mappedBy="type")
     */
    protected $observations;
    
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->observation = new ArrayCollection();
    }

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
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\Observationtype
     */
    public function addObservation(\AppBundle\Entity\iCViburnum\Observation $observation)
    {
        $observation->setType($this);
        $this->observations->add($observation);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getObservations()
    {
        return $this->observations;
    }
}

