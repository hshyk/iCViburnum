<?php

namespace AppBundle\DataFixtures\ORM\iCViburnum;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\iCViburnum\Observationtype;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\iCViburnum\Observationstatus;

class LoadInitialData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {
      $doctrine = $this
            ->container
            ->get('doctrine');
        $em = $doctrine->getManager();
        $basisOfRecordsRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\BasisOfRecords', 'virtualviburnum');
        
        foreach ($basisOfRecordsRepo->findAll() as $basisOfRecord) {
            $observationtype = new Observationtype();
            $observationtype->setId($basisOfRecord->getId());
            $em->persist($observationtype);
            $em->flush();
        }
        
        $observationstatuses = array(Observationstatus::PUBLISHED, Observationstatus::UNPUBLISHED, Observationstatus::REVIEW);
        foreach ($observationstatuses as $observationstatus) {
            $status = new Observationstatus();
            $status->setName($observationstatus);
            $em->persist($status);
            $em->flush();
        }
    }
}