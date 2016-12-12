<?php

namespace AppBundle\Util;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class OrganismUtil implements ContainerAwareInterface {
    
    use ContainerAwareTrait;
    
    public function getPrimaryImageURL($taxon_id)
    {
        $image = $this->container->get('doctrine')->getRepository("AppBundle:VirtualViburnum\Taxon", 'virtualviburnum')->findPrimaryImage($taxon_id);
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
}