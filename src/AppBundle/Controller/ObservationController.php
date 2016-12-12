<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * iCViburnum\Observations controller.
 *
 * @Route("/observations")
 */
class ObservationController extends Controller
{
	/**
	 * Index page for searching.
	 *
	 * @Route("/latest", name="observations_latest")
	 * @Method("GET")
	 */
    public function index() {
        $observations =  $this->getDoctrine()->getRepository('AppBundle:iCViburnum\Observation')->findAllPublished();
        
        $map = $this->get('fungio_google_map.map');
        foreach($observations as $observation) {
            $marker = $this->get('fungio_google_map.marker');
            $marker->setPosition($observation->getLatitude(), $observation->getLongitude());
            $map->addMarker($marker);
        }
        $map->setMapOption('zoom', 1);
        
        return $this->render('observations/index.html.twig', array(
            'observations' => $observations,
            'map' => $map,
        ));
    }
}
