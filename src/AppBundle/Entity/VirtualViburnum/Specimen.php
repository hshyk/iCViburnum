<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specimen
 *
 * @ORM\Table(name="specimens", indexes={@ORM\Index(name="basis_of_record_id", columns={"basis_of_record_id"}), @ORM\Index(name="type_status_id", columns={"type_status_id"}), @ORM\Index(name="institution_id", columns={"institution_id"}), @ORM\Index(name="collection_id", columns={"collection_id"}), @ORM\Index(name="taxon_id", columns={"taxon_id"}), @ORM\Index(name="identification_qualifier_id", columns={"identification_qualifier_id"}), @ORM\Index(name="locality_id", columns={"locality_id"}), @ORM\Index(name="collector_id", columns={"collector_id"}), @ORM\Index(name="reproductive_condition", columns={"reproductive_condition_id"}), @ORM\Index(name="phenology_flower_id", columns={"phenology_flower_id"}), @ORM\Index(name="phenology_fruit_id", columns={"phenology_fruit_id"})})
 * @ORM\Entity
 */
class Specimen
{   
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="specimens_id", type="integer", nullable=false)
     */
    private $specimensId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="basis_of_record_id", type="integer")
     */
    private $basisOfRecordId = '';

    /**
     * @var string
     *
     * @ORM\Column(name="collection_number", type="string", length=45, nullable=false)
     */
    private $collectionNumber = '';

    /**
     * @var string
     *
     * @ORM\Column(name="catalog_number", type="string", length=45, nullable=false)
     */
    private $catalogNumber = '';

    /**
     * @var string
     *
     * @ORM\Column(name="other_catalog_numbers", type="string", length=45, nullable=false)
     */
    private $otherCatalogNumbers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="earliest_date_collected", type="date", nullable=true)
     */
    private $earliestDateCollected;

    /**
     * @var string
     *
     * @ORM\Column(name="begin_day", type="string", length=2, nullable=false)
     */
    private $beginDay;

    /**
     * @var string
     *
     * @ORM\Column(name="begin_month", type="string", length=2, nullable=false)
     */
    private $beginMonth;

    /**
     * @var string
     *
     * @ORM\Column(name="begin_year", type="string", length=4, nullable=false)
     */
    private $beginYear;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="latest_date_collected", type="date", nullable=true)
     */
    private $latestDateCollected;

    /**
     * @var string
     *
     * @ORM\Column(name="end_day", type="string", length=2, nullable=false)
     */
    private $endDay;

    /**
     * @var string
     *
     * @ORM\Column(name="end_month", type="string", length=2, nullable=false)
     */
    private $endMonth;

    /**
     * @var string
     *
     * @ORM\Column(name="end_year", type="string", length=4, nullable=false)
     */
    private $endYear;

    /**
     * @var string
     *
     * @ORM\Column(name="verbatim_event_date", type="string", length=255, nullable=false)
     */
    private $verbatimEventDate;

    /**
     * @var string
     *
     * @ORM\Column(name="etal_collector", type="string", length=255, nullable=false)
     */
    private $etalCollector = '';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=false)
     */
    private $description = '';

    /**
     * @var string
     *
     * @ORM\Column(name="habitat", type="string", length=1000, nullable=false)
     */
    private $habitat;

    /**
     * @var string
     *
     * @ORM\Column(name="reproductive_remarks", type="string", length=512, nullable=false)
     */
    private $reproductiveRemarks;

    /**
     * @var string
     *
     * @ORM\Column(name="identified_by", type="string", length=100, nullable=false)
     */
    private $identifiedBy = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_identified", type="date", nullable=true)
     */
    private $dateIdentified;

    /**
     * @var string
     *
     * @ORM\Column(name="previous_identifications", type="string", length=512, nullable=false)
     */
    private $previousIdentifications;

    /**
     * @var string
     *
     * @ORM\Column(name="rights_holder", type="string", length=255, nullable=false)
     */
    private $rightsHolder;

    /**
     * @var string
     *
     * @ORM\Column(name="rights", type="string", length=255, nullable=false)
     */
    private $rights;

    /**
     * @var string
     *
     * @ORM\Column(name="bibliographic_citation", type="string", length=255, nullable=false)
     */
    private $bibliographicCitation;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="string", length=1000, nullable=false)
     */
    private $notes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=false)
     */
    private $modificationDate = 'CURRENT_TIMESTAMP';

    /**
     * @var Taxon
     *
     * @ORM\ManyToOne(targetEntity="Taxon", inversedBy="specimens")
     * @ORM\JoinColumn(name="taxon_id", referencedColumnName="taxa_id")
     */
    protected $taxon;
    
    /**
     * @var BasisOfRecord
     *
     * @ORM\ManyToOne(targetEntity="BasisOfRecord", inversedBy="specimens")
     * @ORM\JoinColumn(name="basis_of_record_id", referencedColumnName="basis_of_records_id")
     */
    protected $basisOfRecord;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="specimen")
     */
    protected $images;
    
    public function getImages()
    {
        return $this->images;
    }

    public function getTaxon()
    {
        return $this->taxon;
    }

    public function getBasisOfRecord()
    {
        return $this->basisOfRecord;
    }

}

