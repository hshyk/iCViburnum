<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CharacterEventSubscriber
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
    	$character = $eventArgs->getEntity();
    	$emiCViburnum = $eventArgs->getEntityManager();
    	$characterReflProp = $emiCViburnum->getClassMetadata('AppBundle:iCViburnum\Character')
    		->reflClass->getProperty('character');
    	$characterReflProp->setAccessible(true);

    	$emVirtualViburnum = $this->container->get('doctrine')->getManager('virtualviburnum');

    	$characterReflProp->setValue(
    		$character, $emVirtualViburnum->getReference('AppBundle:VirtualViburnum\Characters', $character->getId())
    	);
    }
}