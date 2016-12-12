<?php

namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddressLookupSubscriber implements EventSubscriberInterface
{
    private $mapkey;
    
    public function __construct($mapkey)
    {
        $this->mapkey = $mapkey;
    }
    
    
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SUBMIT => 'preSubmitData');
    }

    public function preSubmitData(FormEvent $event)
    {
        $data = $event->getData();
           
        switch($data['howAdd']) {
            case 'address':
                $coordinates = $this->getMapInfo($data['address']);
                $data['latitude'] = $coordinates['latitude'];
                $data['longitude'] = $coordinates['longitude'];

                if ($data['locationdetail'] == 'New observation') {
                    $data['locationdetail'] = $data['locationdetail']." in ".$coordinates['location'];
                }
                break;
            case 'current':
            case 'map':
                if ($data['locationdetail'] == 'New observation') {
                    $coordinates = $this->getMapInfo($data['latitude'].", ".$data['longitude']);
                    $data['locationdetail'] = $data['locationdetail']." in ".$coordinates['location'];
                    $event->setData($data);
                }
                
                break;
        }
        $event->setData($data);
        
    }
    
    public function getMapInfo($address)
    {
        $geocoder = new \Geocoder\Provider\GoogleMaps(
            new \Ivory\HttpAdapter\CurlHttpAdapter,
            null,
            null,
            true, // true|false
            $this->mapkey
            );
    
        $response = $geocoder->geocode($address)->first();
    
        $location = $response->getLocality();
        foreach($response->getAdminLevels() as $adminLevel) {
            $location .= ", ".$adminLevel->getName();
        }
        $location .= ", ".$response->getCountry();
    
        return array(
            'latitude' =>   $response->getLatitude(),
            'longitude' => $response->getLongitude(),
            'location' => $location,
        );
    }
}