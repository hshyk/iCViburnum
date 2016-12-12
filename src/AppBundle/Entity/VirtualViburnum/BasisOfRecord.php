<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasisOfRecord
 *
 * @ORM\Table(name="basis_of_records", indexes={@ORM\Index(name="value", columns={"value"})})
 * @ORM\Entity
 */
class BasisOfRecord
{
    const HUMAN_OBSERVATION = 'Human Observation';
    const PRESERVED_SPECIMEN = 'Preserved Specimen';
    /**
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(name="basis_of_records_id", type="integer", nullable=false)
     */
    private $basisOfRecordsId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=45, nullable=false)
     */
    private $value;
    
    /**
     * @ORM\OneToMany(targetEntity="Specimen", mappedBy="basisOfRecord")
     */
    protected $specimens;
    
    protected $observationtype;
    
    
    /**
     * Get character_id
     *
     * @return int
     */
    public function getId()
    {
        return $this->basisOfRecordsId;
    }
    
    public function getSpecimens()
    {
        return $this->specimens;
    }
    
    public function getObservationType()
    {

        return $this->observationtype;
    } 


}

