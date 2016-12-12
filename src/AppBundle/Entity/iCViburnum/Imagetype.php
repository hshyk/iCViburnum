<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Imagetype
 *
 * @ORM\Table(name="imagetypes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ImagetypeRepository")
 */
class Imagetype
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="type")
     */
    protected $images;
    
    
    /**
     * Initialize relationships
     */
    public function __construct() {
        $this->states = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Imagetype
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Image $image
     * @return \AppBundle\Entity\iCViburnum\Charactertype
     */
    public function addImage(\AppBundle\Entity\iCViburnum\Image $image)
    {
        $image->setType($this);
        $this->images->add($image);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImagess()
    {
        return $this->images;
    }
}
