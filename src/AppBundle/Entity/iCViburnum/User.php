<?php

namespace AppBundle\Entity\iCViburnum;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;
   
    /**
     * @ORM\OneToMany(targetEntity="Observation", mappedBy="user")
     */
    protected $observations;
    

    public function __construct()
    {
        parent::__construct();
        $this->observations = new ArrayCollection();
    }
    
    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
    	$this->firstName = $firstName;
    
    	return $this;
    }
    
    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
    	return $this->firstName;
    }
    
    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
    	$this->lastName = $lastName;
    
    	return $this;
    }
    
    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
    	return $this->lastName;
    }
    
    /**
     *
     * @param \AppBundle\Entity\iCViburnum\Observation $observation
     * @return \AppBundle\Entity\iCViburnum\User
     */
    public function addObservation(\AppBundle\Entity\iCViburnum\Observation $observation)
    {
        $observation->setOrganism($this);
        $this->organisms->add($observation);
         
        return $this;
    }
    
    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getObservations()
    {
        return $this->observations;
    }    
}
