<?php

namespace AppBundle\Entity\VirtualViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImageRank
 *
 * @ORM\Table(name="image_ranks", indexes={@ORM\Index(name="image_ranks_id", columns={"image_ranks_id"})})
 * @ORM\Entity
 */
class ImageRank
{
    const SPECIMEN_TAXA_IMAGE = "use as specimen & taxon image";
    
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="image_ranks_id", type="integer", nullable=false)
     */
    private $imageRanksId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=48, nullable=false)
     */
    private $value;
    
    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="imagerank")
     */
    protected $images;


}

