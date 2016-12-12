<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="images", indexes={@ORM\Index(name="fk_images_specimens1", columns={"specimen_id"}), @ORM\Index(name="image_rank_id", columns={"image_rank_id"})})
 * @ORM\Entity
 */
class Image
{   
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="images_id", type="integer", nullable=false)
     */
    private $imagesId;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="image_rank_id", type="integer")
     */
    private $imageRankId = '';

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=45, nullable=false)
     */
    private $imageName = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="image_height", type="integer", nullable=false)
     */
    private $imageHeight;

    /**
     * @var integer
     *
     * @ORM\Column(name="image_width", type="integer", nullable=false)
     */
    private $imageWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="image_size", type="string", length=45, nullable=false)
     */
    private $imageSize = '';

    /**
     * @var string
     *
     * @ORM\Column(name="image_type", type="string", length=45, nullable=false)
     */
    private $imageType = '';

    /**
     * @var string
     *
     * @ORM\Column(name="attributes", type="string", length=45, nullable=false)
     */
    private $attributes = '';

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=100, nullable=false)
     */
    private $imagePath = '';

    /**
     * @var string
     *
     * @ORM\Column(name="thumb_path", type="string", length=100, nullable=false)
     */
    private $thumbPath;

    /**
     * @var string
     *
     * @ORM\Column(name="derivative_path", type="string", length=100, nullable=false)
     */
    private $derivativePath;

    /**
     * @var string
     *
     * @ORM\Column(name="image_URL", type="string", length=45, nullable=false)
     */
    private $imageUrl = '';

    /**
     * @var string
     *
     * @ORM\Column(name="imager", type="string", length=100, nullable=false)
     */
    private $imager;

    /**
     * @var string
     *
     * @ORM\Column(name="rights", type="string", length=255, nullable=false)
     */
    private $rights;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255, nullable=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="usage_terms", type="string", length=512, nullable=false)
     */
    private $usageTerms = 'Available under Creative Commons BY-SA 3.0 license';

    /**
     * @var string
     *
     * @ORM\Column(name="licenseURL", type="string", length=512, nullable=false)
     */
    private $licenseurl = 'http://creativecommons.org/licenses/by/3.0/deed.en_US';

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=1000, nullable=false)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="image_remarks", type="string", length=1000, nullable=false)
     */
    private $imageRemarks;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=false)
     */
    private $modificationDate = 'CURRENT_TIMESTAMP';

    /**
     * @var \Specimens
     *
     * @ORM\ManyToOne(targetEntity="Specimen", inversedBy="images")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="specimen_id", referencedColumnName="specimens_id")
     * })
     */
    private $specimen;
    
    /**
     * @var \ImageRank
     *
     * @ORM\ManyToOne(targetEntity="ImageRank")
     * @ORM\JoinColumn(name="image_rank_id", referencedColumnName="image_ranks_id")
     */
    protected $imagerank;
    
    public function getDerivativePath()
    {
        return $this->derivativePath;
    }
    
    public function getThumbPath()
    {
        return $this->thumbPath;
    }
    
    public function getImageRank()
    {
        return $this->imagerank;
    }


}

