<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gadm
 *
 * @ORM\Table(name="gadm")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\GadmRepository")
 */
class Gadm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="gadm_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="parentid", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=75, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="stateprovince", type="string", length=100, nullable=true)
     */
    private $stateProvince;

    /**
     * @var string
     *
     * @ORM\Column(name="districtcountyshire", type="string", length=100, nullable=true)
     */
    private $districtCountyShire;

    /**
     * @var string
     *
     * @ORM\Column(name="admintype", type="string", length=50, nullable=true)
     */
    private $adminType;

    /**
     * @var geometry
     *
     * @ORM\Column(name="geom", type="geometry", nullable=true)
     */
    private $geom;

    /**
     * @var integer
     *
     * @ORM\Column(name="gadmid", type="integer", nullable=true)
     */
    private $gadmId;
    
    /**
     * Get the current region name
     * @var string
     */
    private $currentName;
    
    /**
     * @ORM\OneToMany(targetEntity="Organismgadm", mappedBy="gadm")
     */
    protected $organisms;
    
    /**
     * @ORM\OneToMany(targetEntity="Gadm", mappedBy="parent" )
     */
    protected $divisions;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gadm", inversedBy="divisions")
     * @ORM\JoinColumn(name="parentid", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parent;
    
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->organisms = new ArrayCollection();
        $this->division = new ArrayCollection();
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
     * Set objectId
     *
     * @param integer $parentId
     *
     * @return Gadm
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Gadm
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set districtCountyShire
     *
     * @param string $districtCountyShire
     *
     * @return Gadm
     */
    public function setDistrictcountyshire($districtCountyShire)
    {
        $this->districtCountyShire = $districtCountyShire;

        return $this;
    }

    /**
     * Get districtCountyShire
     *
     * @return string
     */
    public function getDistrictcountyshire()
    {
        return $this->districtCountyShire;
    }

    /**
     * Set adminType
     *
     * @param string $adminType
     *
     * @return Gadm
     */
    public function setAdminType($adminType)
    {
        $this->adminType = $adminType;

        return $this;
    }

    /**
     * Get adminType
     *
     * @return string
     */
    public function getAdminType()
    {
        return $this->adminType;
    }


    /**
     * Set geom
     *
     * @param geometry $geom
     *
     * @return Gadm
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return geometry
     */
    public function getGeom()
    {
        return $this->geom;
    }
    
    /**
     * Set stateProvince
     *
     * @param string $stateProvince
     *
     * @return Gadm
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    
        return $this;
    }
    
    /**
     * Get stateProvince
     *
     * @return string
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }
    
    /**
     * Set gadmId
     *
     * @param integer $gadmId
     *
     * @return Gadm
     */
    public function setGadmId($gadmId)
    {
        $this->gadmId = $gadmId;
    
        return $this;
    }
    
    /**
     * Get gadmId
     *
     * @return int
     */
    public function getGadmId()
    {
        return $this->gadmid;
    }
    
    public function getCurrentName()
    {
        $districtcountyshire = $this->getDistrictcountyshire();
        $stateprovince = $this->getStateProvince();
        
        if (isset($districtcountyshire)) {
            return $this->getDistrictcountyshire();
        }
        else if (isset($stateprovince)) {
            return $this->getStateProvince();
        }
        else {
            return $this->getCountry();
        }
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Organismgadm $organismgadm
     * @return \AppBundle\Entity\iCViburnum\Gadm
     */
    public function addOrganism(\AppBundle\Entity\iCViburnum\Organismgadm $organism)
    {
        $organism->setGadm($this);
        $this->organisms->add($organism);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrganisms()
    {
        return $this->organisms;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDivisions()
    {
        return $this->divisions;
    }
    
    /**
     * Get the parent region
     *
     * @return \AppBundle\Entity\iCViburnum\Gadm
     */
    public function getParent()
    {
        return $this->parent;
    }
}

