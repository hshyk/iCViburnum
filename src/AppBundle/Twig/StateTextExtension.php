<?php

namespace AppBundle\Twig;

class StateTextExtension extends \Twig_Extension
{
	public function getFilters()
	{
		return array(
				new \Twig_SimpleFilter('statetext', array($this, 'stateText')),
		);
	}

	public function stateText($taxon)
	{
		$data = array();
	    foreach ($taxon->getTaxaStates() as $taxastates) {
	      	$state = $taxastates->getState()->getStateName();
	      	$character = $taxastates->getState()->getCharacter()->getCharacterName();
	      	$charactertype = $taxastates->getState()->getCharacter()->getCharacterType()->getCharacterType();
	      	if (!isset($data[$charactertype])) {
	      		$data[$charactertype] = array();
	      		if (!isset($data[$charactertype][$character])) {
	      			$data[$charactertype][$character] = array();
	      		}
	      	}
	      	if (isset($data[$charactertype][$character])) {
	      		array_push($data[$charactertype][$character], $state);
	      	}
      	}
      	
      	foreach($data as &$character) {
      		foreach($character as &$states) {
      			asort($states);
      		}
      		asort($character);	
      	}
      	ksort($data);

		return $data;
	}

	public function getName()
	{
		return 'statetext_extension';
	}
}