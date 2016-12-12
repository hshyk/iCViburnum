<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CrossDBEventSubscriber
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        switch(str_replace("Proxies\\__CG__\\", "", get_class($eventArgs->getEntity()))) {
    		case "AppBundle\Entity\iCViburnum\Organism":
    			$this->createRelation($eventArgs,'AppBundle:iCViburnum\Organism', 'AppBundle:VirtualViburnum\Taxon', 'taxon');
    			break;
    		case "AppBundle\Entity\VirtualViburnum\Taxon":
    		    $this->createReverseRelation($eventArgs,'AppBundle:VirtualViburnum\Taxon', 'AppBundle:iCViburnum\Organism', 'organism');
    		    break;
    		case "AppBundle\Entity\VirtualViburnum\BasisOfRecords":
    		    $this->createReverseRelation($eventArgs,'AppBundle:VirtualViburnum\BasisOfRecord', 'AppBundle:iCViburnum\Observationtype', 'observationtype');
    		    break;		   
    	}
    	
    }
    
    private function createRelation($eventArgs, $primaryclass, $relatedclass, $property)
    {
    	$entity = $eventArgs->getEntity();
    	$emiCViburnum = $eventArgs->getEntityManager();
    	$reflProp = $emiCViburnum->getClassMetadata($primaryclass)
    	    ->reflClass->getProperty($property);
    	$reflProp->setAccessible(true);
    	
    	$emVirtualViburnum = $this->container->get('doctrine')->getManager('virtualviburnum');
    	
    	$reflProp->setValue(
    		$entity, $emVirtualViburnum->getReference($relatedclass, $entity->getId())
    	);
    }
    
    private function createReverseRelation($eventArgs, $primaryclass, $relatedclass, $property)
    {
    	$entity = $eventArgs->getEntity();
    	$emVirtualViburnum = $eventArgs->getEntityManager();
    	$reflProp = $emVirtualViburnum->getClassMetadata($primaryclass)
    	    ->reflClass->getProperty($property);
    	$reflProp->setAccessible(true);
    	
    	$emiCViburnum = $this->container->get('doctrine')->getManager('icviburnum');
    	
    	$reflProp->setValue(
    		$entity, $emiCViburnum->getReference($relatedclass, $entity->getId())
    	);
    }
}