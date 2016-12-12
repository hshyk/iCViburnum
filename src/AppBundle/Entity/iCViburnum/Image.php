<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="observation_id", type="integer", nullable=true)
     */
    private $observationId;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="photographer", type="text", nullable=true)
     */
    private $photographer;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var string
     *
     * @ORM\Column(name="copyright", type="text", nullable=true)
     */
    private $copyright;

    /**
     * @var string
     *
     * @ORM\Column(name="infodisplay", type="text", nullable=true)
     */
    private $infodisplay;

    /**
     * @var int
     *
     * @ORM\Column(name="charactertype_id", type="integer", nullable=true)
     */
    private $charactertypeId;

    /**
     * @var int
     *
     * @ORM\Column(name="imagetype_id", type="integer", nullable=true)
     */
    private $imagetypeId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Observation", inversedBy="images")
     * @ORM\JoinColumn(name="observation_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $observation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Imagetype", inversedBy="images")
     * @ORM\JoinColumn(name="imagetype_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="images")
     * @ORM\JoinTable(name="images_tags")
     */
    protected $tags;
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->tags = new ArrayCollection;
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
     * Set observationId
     *
     * @param integer $observationId
     *
     * @return Image
     */
    public function setObservationId($observationId)
    {
        $this->observationId = $observationId;

        return $this;
    }

    /**
     * Get observationId
     *
     * @return int
     */
    public function getObservationId()
    {
        return $this->observationId;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Image
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set photographer
     *
     * @param string $photographer
     *
     * @return Image
     */
    public function setPhotographer($photographer)
    {
        $this->photographer = $photographer;

        return $this;
    }

    /**
     * Get photographer
     *
     * @return string
     */
    public function getPhotographer()
    {
        return $this->photographer;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Image
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set copyright
     *
     * @param string $copyright
     *
     * @return Image
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * Get copyright
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Set infodisplay
     *
     * @param string $infodisplay
     *
     * @return Image
     */
    public function setInfodisplay($infodisplay)
    {
        $this->infodisplay = $infodisplay;

        return $this;
    }

    /**
     * Get infodisplay
     *
     * @return string
     */
    public function getInfodisplay()
    {
        return $this->infodisplay;
    }

    /**
     * Set charactertypeId
     *
     * @param integer $charactertypeId
     *
     * @return Image
     */
    public function setCharactertypeId($charactertypeId)
    {
        $this->charactertypeId = $charactertypeId;

        return $this;
    }

    /**
     * Get charactertypeId
     *
     * @return int
     */
    public function getCharactertypeId()
    {
        return $this->charactertypeId;
    }

    /**
     * Set imagetypeId
     *
     * @param integer $imagetypeId
     *
     * @return Image
     */
    public function setImagetypeId($imagetypeId)
    {
        $this->imagetypeId = $imagetypeId;

        return $this;
    }

    /**
     * Get imagetypeId
     *
     * @return int
     */
    public function getImagetypeId()
    {
        return $this->imagetypeId;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\Image
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    
        return $this;
    }
    
    /**
     * return \AppBundle\Entity\iCViburnum\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Imagetype $type
     * @return \AppBundle\Entity\iCViburnum\Image
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }
    
    /**
     * return \AppBundle\Entity\iCViburnum\Imagetype
     */
    public function getType()
    {
        return $this->type;
    }
}
