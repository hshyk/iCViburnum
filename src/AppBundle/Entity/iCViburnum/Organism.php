<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organism
 *
 * @ORM\Table(name="organisms")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\OrganismRepository")
 */
class Organism
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
    private $primaryImage;
    
    private $total;
    
    /**
     * @ORM\OneToMany(targetEntity="Observation", mappedBy="organism")
     */
    protected $observations;
    
    /**
     * @ORM\OneToMany(targetEntity="Organismgadm", mappedBy="organism")
     */
    protected $gadms;
    
    /**
     * @ORM\OneToMany(targetEntity="Organismstate", mappedBy="organism")
     */
    protected $states;
    
    /**
     * Cross DB Entity
     * @var \AppBundle\Entity\VirtualViburnum\Taxon
     */
    protected $taxon;
    

    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->observations = new ArrayCollection;
        $this->gadms = new ArrayCollection();
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
    
    public function setUrl($url)
    {
    	$url = trim($url);
    	$url = preg_replace("/[^A-Za-z0-9 ]/", '', $url);
    	$url = str_replace(" ", "-", $url);
    	$url = strtolower($url);
    	$this->url = $url;
    }
    
    public function getUrl()
    {
    	return $this->url;
    }
    
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\Organism
     */
    public function addObservation(\AppBundle\Entity\iCViburnum\Observation $observation)
    {
        $observation->setOrganism($this);
        $this->organisms->add($observation);
         
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
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Organismgadm $gadm
     * @return \AppBundle\Entity\iCViburnum\Organism
     */
    public function addGadm(\AppBundle\Entity\iCViburnum\Organismgadm $gadm)
    {
        $gadm->setOrganism($this);
        $this->organisms->add($gadm);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getGadms()
    {
        return $this->gadms;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Organismstate $state
     * @return \AppBundle\Entity\iCViburnum\Organism
     */
    public function addState(\AppBundle\Entity\iCViburnum\Organismstate $state)
    {
        $state->setOrganism($this);
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
    
    public function getTaxon()
    {
    	// Need to call getId so that the object is loaded
    	//$this->taxon->getId();
    	return $this->taxon;
    }
}
