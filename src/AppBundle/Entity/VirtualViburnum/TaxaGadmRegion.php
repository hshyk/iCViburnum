<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaxaGadmRegion
 *
 * @ORM\Table(name="taxa_gadm_regions", indexes={@ORM\Index(name="taxon_id", columns={"taxon_id"}), @ORM\Index(name="gadm_region_id", columns={"gadm_region_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VirtualViburnum\TaxaGadmRegionRepository")
 */
class TaxaGadmRegion
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="taxa_gadm_regions_id", type="integer", nullable=false)
     */
    private $taxaGadmRegionsId;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=512, nullable=false)
     */
    private $source;
    
    /**
     * @var int
     *
     * @ORM\Column(name="gadm_region_id", type="integer")
     */
    private $gadmRegionId;
    
    /**
     * @var int
     *
     * @ORM\Column(name="taxon_id", type="integer")
     */
    private $taxonId;

    /**
     * @var \GadmRegion
     *
     * @ORM\ManyToOne(targetEntity="GadmRegion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gadm_region_id", referencedColumnName="gadm_regions_id")
     * })
     */
    private $gadmRegion;

    /**
     * @var \Taxon
     *
     * @ORM\ManyToOne(targetEntity="Taxon")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="taxon_id", referencedColumnName="taxa_id")
     * })
     */
    private $taxon;
    
    public function getId()
    {
        return $this->taxaGadmRegionsId;
    }
    
    public function getTaxonId()
    {
        return $this->taxonId;
    }
    
    public function getGadmRegionId()
    {
        return $this->gadmRegionId;
    }
    
    public function getTaxon()
    {
        return $this->taxon;
    }
}

