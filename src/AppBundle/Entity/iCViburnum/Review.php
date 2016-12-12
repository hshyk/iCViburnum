<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\iCViburnum\ReviewRepository")
 */
class Review
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
     * @ORM\Column(name="observation_id", type="integer")
     */
    private $observationId;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;
    
    /**
     * @ORM\ManyToOne(targetEntity="Observation", inversedBy="reviews")
     * @ORM\JoinColumn(name="observation_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $observation;


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
     * @return Review
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
     * Set comments
     *
     * @param string $comments
     *
     * @return Review
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Review
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
     * Set the observation
     * 
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\Review
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;
    
        return $this;
    }
    
    /**
     * Get the observation
     * 
     * return \AppBundle\Entity\iCViburnum\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }
}

