<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\iCViburnum\Observation;
use AppBundle\Form\iCViburnum\ObservationType;
use AppBundle\Entity\VirtualViburnum\BasisOfRecords;
use Fungio\GoogleMap\Services\Geocoding\GeocoderRequest;
use Fungio\GoogleMap\Services\Geocoding\Geocoder;
use Fungio\GoogleMap\Services\Geocoding\GeocoderProvider;
use Geocoder\HttpAdapter\CurlHttpAdapter;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Filesystem\Filesystem;



/**
 * Observation controller.
 *
 */
class UserController extends Controller
{
    /**
	 * Index page for searching.
	 *
	 * @Route("/user", name="user_main")
	 * @Method("GET")
	 */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('user/index.html.twig', array(
            'user' => $user
        ));
    }

}
