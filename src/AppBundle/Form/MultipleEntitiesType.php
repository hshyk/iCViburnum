<?php

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;


abstract class MultipleEntitiesType extends AbstractType {
    
    public $managerRegistry;
    
    /**
     * Constructor
     *
     * @param Doctrine $doctrine
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
}