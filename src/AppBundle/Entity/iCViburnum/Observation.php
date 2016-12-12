<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Observation
 *
 * @ORM\Table(name="observations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ObservationRepository")
 */
class Observation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="datum", type="string", length=50)
     */
    private $datum = "WGS 84";

    /**
     * @var int
     *
     * @ORM\Column(name="type_id", type="integer", nullable=true)
     */
    private $typeId;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var geometry
     *
     * @ORM\Column(name="geom", type="geometry", nullable=true)
     */
    private $geom;

    /**
     * @var string
     *
     * @ORM\Column(name="locationdetail", type="text", nullable=true)
     */
    private $locationdetail = "New Observation";

    /**
     * @var int
     *
     * @ORM\Column(name="status_id", type="integer")
     */
    private $statusId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_observed", type="date", nullable=true)
     * @Assert\NotBlank()
     */
    private $dateObserved;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=true)
     */
    private $dateModified;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="observation")
     */
    protected $images;
    
    /**
     * @ORM\ManyToOne(targetEntity="Organism", inversedBy="observations")
     * @ORM\JoinColumn(name="organism_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $organism;
    
    /**
     * @ORM\ManyToOne(targetEntity="Observationstatus", inversedBy="observations")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $status;
    
    /**
     * @ORM\ManyToOne(targetEntity="Observationtype", inversedBy="observations")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="observations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $user;
    

    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->images = new ArrayCollection();
        $this->dateAdded = new \DateTime();
        $this->dateModified = new \DateTime();
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
     * @return Observation
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Observation
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set datum
     *
     * @param string $datum
     *
     * @return Observation
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;

        return $this;
    }

    /**
     * Get datum
     *
     * @return string
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set observationtypeId
     *
     * @param integer $observationtypeId
     *
     * @return Observation
     */
    public function setObservationtypeId($observationtypeId)
    {
        $this->observationtypeId = $observationtypeId;

        return $this;
    }

    /**
     * Get observationtypeId
     *
     * @return int
     */
    public function getObservationtypeId()
    {
        return $this->observationtypeId;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set geom
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return Observation
     */
    public function setGeom($latitude, $longitude)
    {
        $this->geom = 'POINT('.$longitude.' '.$latitude.')';

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
     * Set locationdetail
     *
     * @param string $locationdetail
     *
     * @return Observation
     */
    public function setLocationdetail($locationdetail)
    {
        $this->locationdetail = $locationdetail;

        return $this;
    }

    /**
     * Get locationdetail
     *
     * @return string
     */
    public function getLocationdetail()
    {
        return $this->locationdetail;
    }

    /**
     * Set statusId
     *
     * @param integer $statusId
     *
     * @return Observation
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return int
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set dateObserved
     *
     * @param \DateTime $dateObserved
     *
     * @return Observation
     */
    public function setDateObserved($dateObserved)
    {
        $this->dateObserved = $dateObserved;

        return $this;
    }

    /**
     * Get dateObserved
     *
     * @return \DateTime
     */
    public function getDateObserved()
    {
        return $this->dateObserved;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Observation
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     *
     * @return Observation
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Image $image
     * @return \AppBundle\Entity\iCViburnum\Observation
     */
    public function addImage(\AppBundle\Entity\iCViburnum\Image $image)
    {
        $image->setObservation($this);
        $this->images->add($image);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
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
     * Get the status
     *
     * @return \AppBundle\Entity\iCViburnum\Status
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set the status
     *
     * @param \AppBundle\Entity\iCViburnum\Observationstatus $status
     * @return \AppBundle\Entity\iCViburnum\Observation
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }
    
    /**
     * Set the user
     * 
     * @param \AppBundle\Entity\iCViburnum\User $user
     * @return \AppBundle\Entity\iCViburnum\Observation
     */
    public function setUser($user)
    {
        $this->user = $user;
        
        return $this;
    }
    
    /**
     * Get the user
     * 
     * @return \AppBundle\Entity\iCViburnum\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set the type
     *
     * @param \AppBundle\Entity\iCViburnum\Observationtype $type
     * @return \AppBundle\Entity\iCViburnum\Observation
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }
    
    /**
     * Get the type
     *
     * @return \AppBundle\Entity\iCViburnum\Observationtype
     */
    public function getType()
    {
        return $this->type;
    }
}
