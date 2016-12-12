<?php

namespace AppBundle\Command;

use AppBundle\Entity\iCViburnum\Organism;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\iCViburnum\Charactertype;
use AppBundle\Entity\iCViburnum\Character;
use AppBundle\Entity\iCViburnum\State;
use AppBundle\Entity\iCViburnum\Organismgadm;
use AppBundle\Entity\iCViburnum\Organismstate;

class SyncDBCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
		->setName('app:syncdb')
		->setDescription('Syncs the database from MySQL to PostgreSQL');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->syncTaxaToOrganism();
		$this->syncCharacterTypes();
		$this->syncCharacters();
		$this->syncStates();
		$this->syncOrganismTaxaStates();
		$this->syncOrganismsGadm();
	}
	
	private function syncTaxaToOrganism()
	{
		$doctrine = $this
		->getContainer()
		->get('doctrine');
		$organismRepo= $doctrine->getRepository("AppBundle:iCViburnum\Organism");
		$taxaRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\Taxon', 'virtualviburnum');
		$organismEm = $doctrine->getManager('icviburnum');
		
		$organismIds = array_column(
				$organismRepo
				->findAllIDs(),
				"id"
				);
		if (empty($organismIds)) {
			$organismIds = array(0);
		}
		
		$taxa= $taxaRepo->findAllByNotIDs($organismIds);
		$i = 0;
		foreach ($taxa as $taxon) {
			$organism = new Organism();
			$organism->setId($taxon->getId());
			$organism->setUrl($taxon->getScientificName());
		
			$organismEm->persist($organism);
		
			// flush everything to the database every 20 inserts
			if (($i % 20) == 0) {
				$organismEm->flush();
				$organismEm->clear();
			}
			$i++;
		}
		
		// flush the remaining objects
		$organismEm->flush();
		$organismEm->clear();
	}

	private function syncCharacterTypes()
	{
	    $doctrine = $this
	    ->getContainer()
	    ->get('doctrine');
	    
	    $icCharTypeRepo= $doctrine->getRepository("AppBundle:iCViburnum\Charactertype");
	    $vvCharTypeRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\CharacterType', 'virtualviburnum');
	    $icCharTypeEm = $doctrine->getManager('icviburnum');
	    
	    $typeIds = array_column(
	        $icCharTypeRepo
	        ->findAllIDs(),
	        "id"
	        );
	    if (empty($typeIds)) {
	        $typeIds = array(0);
	    }
	    
	   $charTypes = $vvCharTypeRepo->findAllByNotIDs($typeIds);
	    $i = 0;
	    foreach ($charTypes as $charType) {
	        $type = new Charactertype();
	        $type->setId($charType->getId());
	    
	        $icCharTypeEm->persist($type);
	    
	        // flush everything to the database every 20 inserts
	        if (($i % 20) == 0) {
	            $icCharTypeEm->flush();
	            $icCharTypeEm->clear();
	        }
	        $i++;
	    }
	    
	    // flush the remaining objects
	    $icCharTypeEm->flush();
	    $icCharTypeEm->clear();
	}
	
	private function syncCharacters()
	{
	    $doctrine = $this
	    ->getContainer()
	    ->get('doctrine');
	     
	    $icCharacterRepo= $doctrine->getRepository("AppBundle:iCViburnum\Character");
	    $vvCharacterRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\Character', 'virtualviburnum');
	    $icCharacterEm = $doctrine->getManager('icviburnum');
	     
	    $characterIds = array_column(
	        $icCharacterRepo
	        ->findAllIDs(),
	        "id"
	        );
	    if (empty($characterIds)) {
	        $characterIds = array(0);
	    }
	     
	    $characters = $vvCharacterRepo->findAllByNotIDs($characterIds);
	    $i = 0;
	    foreach ($characters as $character) {
	        $char = new Character();
	        $char->setId($character->getId());
	        $char->setIsNumeric($character->getIsNumeric());
	        $char->setType($icCharacterEm->getReference('AppBundle:iCViburnum\Charactertype', $character->getCharacterTypeId()));
	         
	        $icCharacterEm->persist($char);
	         
	        // flush everything to the database every 20 inserts
	        if (($i % 20) == 0) {
	            $icCharacterEm->flush();
	            $icCharacterEm->clear();
	        }
	        $i++;
	    }
	     
	    // flush the remaining objects
	    $icCharacterEm->flush();
	    $icCharacterEm->clear();
	}
	
	private function syncStates()
	{
	    $doctrine = $this
	    ->getContainer()
	    ->get('doctrine');
	
	    $icStateRepo= $doctrine->getRepository("AppBundle:iCViburnum\State");
	    $vvStateRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\State', 'virtualviburnum');
	    $icStateEm = $doctrine->getManager('icviburnum');
	
	    $stateIds = array_column(
	        $icStateRepo
	        ->findAllIDs(),
	        "id"
	        );
	    if (empty($stateIds)) {
	        $stateIds = array(0);
	    }
	
	    $states = $vvStateRepo->findAllByNotIDs($stateIds);
	    $i = 0;
	    foreach ($states as $state) {
	        $st = new State();
	        $st->setId($state->getId());
	        $st->setCharacter($icStateEm->getReference('AppBundle:iCViburnum\Character', $state->getCharacterId()));
	
	        $icStateEm->persist($st);
	
	        // flush everything to the database every 20 inserts
	        if (($i % 20) == 0) {
	            $icStateEm->flush();
	            $icStateEm->clear();
	        }
	        $i++;
	    }
	
	    // flush the remaining objects
	    $icStateEm->flush();
	    $icStateEm->clear();
	}
	
	private function syncOrganismsGadm()
	{

	    $doctrine = $this
	    ->getContainer()
	    ->get('doctrine');
	     
	    $icOrganismGadmRepo= $doctrine->getRepository("AppBundle:iCViburnum\Organismgadm");
	    $vvTaxaGadmRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\TaxaGadmRegion', 'virtualviburnum');
	    $icOrganismGadmEm = $doctrine->getManager('icviburnum');
	    
	    $taxaGadmIds = array_column(
	        $icOrganismGadmRepo
	        ->findAllIDs(),
	        "id"
	        );
	    if (empty($taxaGadmIds)) {
	        $taxaGadmIds = array(0);
	    }
	   
	    $taxaGadms = $vvTaxaGadmRepo->findAllByNotIDs($taxaGadmIds);
	    $i = 0;

	    foreach ($taxaGadms as $taxaGadm) {
	        $organismGadm = new Organismgadm();
	        $organismGadm->setId($taxaGadm->getId());
	        $organismGadm->setOrganism($icOrganismGadmEm->getReference('AppBundle:iCViburnum\Organism', $taxaGadm->getTaxonId()));
	        $organismGadm->setGadm($icOrganismGadmEm->getReference('AppBundle:iCViburnum\Gadm', $taxaGadm->getGadmRegionId()));
	         
	        $icOrganismGadmEm->persist($organismGadm);
	         
	        // flush everything to the database every 20 inserts
	        if (($i % 20) == 0) {
	            $icOrganismGadmEm->flush();
	            $icOrganismGadmEm->clear();
	        }
	        $i++;
	    }
	     
	    // flush the remaining objects
	    $icOrganismGadmEm->flush();
	    $icOrganismGadmEm->clear();
	}
	
	private function syncOrganismTaxaStates()
	{
	    $doctrine = $this
	    ->getContainer()
	    ->get('doctrine');
	    
	    $icOrganismStateRepo= $doctrine->getRepository("AppBundle:iCViburnum\Organismstate");
	    $vvTaxaStateRepo = $doctrine->getRepository('AppBundle:VirtualViburnum\TaxaState', 'virtualviburnum');
	    $icOrganismStateEm = $doctrine->getManager('icviburnum');
	    
	    $taxaStateIds = array_column(
	        $icOrganismStateRepo
	        ->findAllIDs(),
	        "id"
	        );
	    if (empty($taxaStateIds)) {
	        $taxaStateIds = array(0);
	    }
	     
	    $taxaStates = $vvTaxaStateRepo->findAllByNotIDs($taxaStateIds);
	    $i = 0;
	    foreach ($taxaStates as $taxaState) {
	        $organismState = new Organismstate();
	        $organismState->setId($taxaState->getId());
	        $organismState->setOrganism($icOrganismStateEm->getReference('AppBundle:iCViburnum\Organism', $taxaState->getTaxonId()));
	        $organismState->setState($icOrganismStateEm->getReference('AppBundle:iCViburnum\State', $taxaState->getStateId()));
	        $organismState->setLowValue($taxaState->getLowValue());
	        $organismState->setHighValue($taxaState->getHighValue());
	        
	        $icOrganismStateEm->persist($organismState);
	    
	        // flush everything to the database every 20 inserts
	        if (($i % 20) == 0) {
	            $icOrganismStateEm->flush();
	            $icOrganismStateEm->clear();
	        }
	        $i++;
	    }
	    
	    // flush the remaining objects
	    $icOrganismStateEm->flush();
	    $icOrganismStateEm->clear();
	}
}