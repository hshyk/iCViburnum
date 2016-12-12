<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\VirtualViburnum\Taxon;
use AppBundle\Form\Type\SearchByNameType;
use AppBundle\Form\Type\SearchByDescriptionType;
use AppBundle\Form\Type\SearchByLocationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * VirtualViburnum\Taxon controller.
 *
 * @Route("/search")
 */
class SearchController extends Controller
{
    public function getPrimaryImageURL($taxon_id)
    {
        $image = $this->getDoctrine()->getRepository("AppBundle:VirtualViburnum\Taxon", 'virtualviburnum')->findPrimaryImage($taxon_id);
        $imageUrl = "";
        if (isset($image[0])) {
            $imageUrl = $this->container->getParameter('virtualviburnum_image_server').$image[0]['thumbPath'];
        }
        return $imageUrl;
    }
    
    public function getShortName($scientificName)
    {    
        if (strlen($scientificName) > 30) {
             return substr($scientificName, 0, 30)."...";
        }
        else {
            return $scientificName;
        }
    }
    
	/**
	 * Index page for searching.
	 *
	 * @Route("/", name="search")
	 * @Method("GET")
	 */
    public function index() {
	    return $this->render('search/index.html.twig');
    }
	
    /**
     * Form for searching Viburnum by name.
     *
     * @Route("/name", name="search_name")
     * @Method("GET")
     */
    public function searchNameAction() {
    	$form = $this->createForm(SearchByNameType::class);
    	
    	return $this->render('search/name.html.twig', array(
    		'form' => $form->createView(),
    	));
    }
    
    /**
     * Finds and displays a VirtualViburnum Taxon entity.
     *
     * @Route("/name/ajax", name="search_name_ajax")
     * @Method("POST")
     */
    public function searchNameAjaxAction(Request $request) {

    	if($request->isXmlHttpRequest()) {
    	    $page = (int)$request->request->get('page');
    	    
    	    $page = $page * 10;
    	    
    	    $taxa = $this
    	        ->getDoctrine()
    	        ->getRepository("AppBundle:VirtualViburnum\Taxon", 'virtualviburnum')
    	        ->findAllByName($request->request->get('name'), $page);
    	    
    	    $info = array();

    	    foreach($taxa as $taxon) {
    	        $scientificName = $taxon->getScientificName();
    	        $organismUtil = $this->get('app.util.organism_util');
    	        array_push($info, array(
    	            'scientificName' => $scientificName,
    	            'shortName' => $organismUtil->getShortName($scientificName),
    	            'url' => $taxon->getOrganism()->getURL(),
    	            'image' =>$organismUtil->getPrimaryImageURL($taxon->getId())));
    	    }
    	    
    	    return new JsonResponse(array('organisms' => $info));
    	}
    }
    
    
    /**
     * Finds and displays a taxa by location.
     *
     * @Route("/location", name="search_location")
     * @Method({"GET","POST"})
     */
    public function searchLocationAction() {
    	$form = $this->createForm(SearchByLocationType::class);
    	return $this->render('search/location.html.twig', array(
    	    'map' => $this->get('fungio_google_map.map'),
    		'form' => $form->createView(),
    	));
    }
        
	/**
	 * Finds and displays a VirtualViburnum Taxon entity.
	 *
	 * @Route("/location/ajax", name="search_location_ajax")
	 * @Method("POST")
	 */
	public function searchLocationAjaxAction(Request $request) {
	
	    if($request->isXmlHttpRequest()) {
	        $type = $request->request->get('type');
	        $page = (int)$request->request->get('page');
	        $latitude = $request->request->get('latitude');
	        $longitude = $request->request->get('longitude');
	        $regions = $request->request->get('regions');

	        $page = $page * 10;
	        
	        switch($type) {
	            case 'current':
	            case 'map':
	                if (empty($latitude) || empty($longitude)) {
	                    return new JsonResponse(array("success" => false, 'error' => "We could not determine the location you chose. Please try again or use another option."));
	                }
	                $organisms = $this
	                   ->getDoctrine()
	                   ->getRepository("AppBundle:iCViburnum\Organism", 'icviburnum')
	                   ->findAllByLocation($latitude, $longitude, $page);
	                break;
	            case 'region':
	                foreach($regions as $key => $region) {
	                    if (empty($region)) {
	                        unset($regions[$key]);
	                    }
	                }
 	                $organisms = $this
	                ->getDoctrine()
	                ->getRepository("AppBundle:iCViburnum\Organism", 'icviburnum')
	                ->findAllByRegions($regions, $page);
	                break;
	        }

	        


	        $info = array();
	        
	        foreach($organisms as $organism) {
	            $scientificName = $organism->getTaxon()->getScientificName();
	            $organismUtil = $this->get('app.util.organism_util');
	            array_push($info, array(
	                'scientificName' =>$scientificName,
	                'shortName' => $organismUtil->getShortName($scientificName),
	                'url' => $organism->getURL(),
	                'image' =>$organismUtil->getPrimaryImageURL($organism->getId())
	            ));
	        }
	        	
	        return new JsonResponse(array("success" => true, 'organisms' => $info));
	    }
	}
	
    /**
     * Finds and displays a VirtualViburnum Taxon entity.
     *
     * @Route("/description", name="search_description")
     * @Method({"GET","POST"})
     */
    public function searchDescriptionAction(Request $request) {
    	$form = $this->createForm(SearchByDescriptionType::class);
    	$form->handleRequest($request);
    	return $this->render('search/description.html.twig', array(
    		'form' => $form->createView(),
    	));
    }
    
    /**
     * Finds and displays a VirtualViburnum Taxon entity.
     *
     * @Route("/description/ajax", name="search_description_ajax")
     * @Method("POST")
     */
    public function searchDescriptionAjaxAction(Request $request) {

        if($request->isXmlHttpRequest()) {
            
            $states = $request->request->get('states');
            $values = $request->request->get('values');
            $page = (int)$request->request->get('page');
            
            $page = $page * 10;
            
            $organisms = $this
                ->getDoctrine()
                ->getRepository("AppBundle:iCViburnum\Organism", 'icviburnum')
                ->findAllByDescription($states, $values, $page);
    
            $info = array();
    
            foreach($organisms as $organism) {
                $scientificName = $organism->getTaxon()->getScientificName();
                $organismUtil = $this->get('app.util.organism_util');
                array_push($info, array(
                    'scientificName' =>$scientificName,
	                'shortName' => $organismUtil->getShortName($scientificName),
                    'url' => $organism->getURL(),
                    'image' =>$organismUtil->getPrimaryImageURL($organism->getId())
                    
                ));
            }
    
            return new JsonResponse(array('organisms' => $info, 'success' => true));
        }
    }
}
