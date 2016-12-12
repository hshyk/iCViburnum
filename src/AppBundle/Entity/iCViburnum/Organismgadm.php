<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Organismgadm
 *
 * @ORM\Table(name="organismgadms")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\OrganismgadmRepository")
 */
class Organismgadm
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
     * @ORM\Column(name="gadm_id", type="integer")
     */
    private $gadmId;

    /**
     * @ORM\ManyToOne(targetEntity="Organism", inversedBy="gadms")
     * @ORM\JoinColumn(name="organism_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $organism;

    /**
     * @ORM\ManyToOne(targetEntity="Gadm", inversedBy="organisms")
     * @ORM\JoinColumn(name="gadm_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $gadm;


    /**
     * Set the id
     *
     * @return Organismgadm
     */
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
     * @return Organismgadm
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
     * Set gadmId
     *
     * @param integer $gadmId
     *
     * @return Organismgadm
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
        return $this->gadmId;
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
     * Set the Gadm
     *
     * @param \AppBundle\Entity\iCViburnum\Gadm $gadm
     * @return \AppBundle\Entity\iCViburnum\Organismgadm
     */
    public function setGadm($gadm)
    {
        $this->gadm = $gadm;

        return $this;
    }

    /**
     * Get the Gadm
     *
     * @return \AppBundle\Entity\iCViburnum\Gadm
     */
    public function getGadm()
    {
        return $this->gadm;
    }
}
