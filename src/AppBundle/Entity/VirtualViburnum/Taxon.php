<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Taxon
 *
 * @ORM\Table(name="taxa", indexes={@ORM\Index(name="taxon_status_id", columns={"taxon_status_id"}), @ORM\Index(name="specific_epithet_author", columns={"specific_epithet_author_id"}), @ORM\Index(name="taxon_accepted_id", columns={"taxon_accepted_id"}), @ORM\Index(name="genus_id", columns={"genus_id"}), @ORM\Index(name="nomenclatural_status_id", columns={"nomenclatural_status_id"}), @ORM\Index(name="title_id", columns={"protologue_title"}), @ORM\Index(name="clade_id", columns={"clade_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\TaxonRepository")
 */
class Taxon
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="taxa_id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     */
    private $taxaId;

    /**
     * @var string
     *
     * @ORM\Column(name="scientific_name", type="string", length=250, nullable=false)
     */
    private $scientificName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="genus", type="string", length=45, nullable=false)
     */
    private $genus;

    /**
     * @var \Taxon
     *
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taxon_accepted_id", referencedColumnName="taxa_id")
     * })
     */
    private $taxonAccepted;
    
    /**
     * @var \TaxonStatus
     *
     * @ORM\ManyToOne(targetEntity="TaxonStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taxon_status_id", referencedColumnName="taxon_statuses_id")
     * })
     */
    private $taxonStatus;
    
    /**
     * @ORM\OneToMany(targetEntity="TaxaState", mappedBy="taxon")
     */
    protected $taxastates;
    
    /**
     * @ORM\OneToMany(targetEntity="Specimen", mappedBy="taxon")
     */
    protected $specimens;
    
    protected $organism;  

	
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
    	return $this->taxaId;
    }
    
    /**
     * Get scientificName
     *
     * @return string
     */
    public function getScientificName()
    {
    	return $this->scientificName;
    }
   
    /**
     * Get genus
     *
     * @return string
     */
    public function getGenus()
    {
    	return $this->genus;
    }
    
    public function getStatus()
    {
    	return $this->taxonStatus;
    }
    
    public function getTaxaStates()
    {
    	return $this->taxastates;
    }
    
    public function getSpecimens()
    {
        return $this->specimens;
    }
    
    public function getOrganism()
    {
        //$this->organism->getId();
        return $this->organism;
    }
    

}
