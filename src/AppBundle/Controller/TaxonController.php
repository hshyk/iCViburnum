<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VirtualViburnum\Taxon;

/**
 * VirtualViburnum\Taxon controller.
 *
 * @Route("/taxon")
 */
class TaxonController extends Controller
{
    /**
     * Finds and displays a VirtualViburnum Taxon entity.
     *
     * @Route("/{url_name}", name="taxon_show")
     * @Method("GET")
     */
    public function showAction($url_name)
    {
    	$organism = $this->get('doctrine')->getRepository('AppBundle:iCViburnum\Organism')->findByURL($url_name);
		$taxon = $organism->getTaxon();
		$images = $this->get('doctrine')->getRepository("AppBundle:VirtualViburnum\Taxon", 'virtualviburnum')->findImages($taxon->getId());
    	
        return $this->render('taxon/show.html.twig', array(
            'taxon' => $taxon,
            'images' => $images
        ));
    }
}
