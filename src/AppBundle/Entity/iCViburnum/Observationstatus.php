<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Observationstatus
 *
 * @ORM\Table(name="observationstatuses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ObservationstatusRepository")
 */
class Observationstatus
{
    const PUBLISHED = 'Published';
    const UNPUBLISHED = 'Unpublished';
    const REVIEW = 'Send For Review';
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Observation", mappedBy="status")
     */
    protected $observations;
    
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->observation = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Observationstatus
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\Observationstatus
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
