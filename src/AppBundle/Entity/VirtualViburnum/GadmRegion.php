<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * GadmRegion
 *
 * @ORM\Table(name="gadm_regions")
 * @ORM\Entity
 */
class GadmRegion
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="gadm_regions_id", type="integer", nullable=false)
     */
    private $gadmRegionsId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parentid", type="integer", nullable=true)
     */
    private $parentid;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="stateProvince", type="string", length=255, nullable=false)
     */
    private $stateProvince;
    
    /**
     * @var string
     *
     * @ORM\Column(name="districtCountyShire", type="string", length=255, nullable=false)
     */
    private $districtcountyshire;

    /**
     * @var string
     *
     * @ORM\Column(name="adminType", type="string", length=255, nullable=false)
     */
    private $admintype;


}

