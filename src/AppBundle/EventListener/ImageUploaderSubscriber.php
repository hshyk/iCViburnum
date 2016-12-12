<?php

namespace AppBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\iCViburnum\Observation;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Filesystem\Filesystem;
use AppBundle\Entity\iCViburnum\Image;

class ImageUploaderSubscriber implements EventSubscriber
{
    private $request;
    private $tokenStorage;
    private $rootDir;
    
    public function __construct(RequestStack $request_stack, TokenStorage $tokenStorage, $rootDir)
    {
        $this->request = $request_stack->getCurrentRequest();
        $this->tokenStorage = $tokenStorage;
        $this->rootDir = $rootDir;
    }
    
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->addNewImages($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->addNewImages($args);
    }

    public function addNewImages(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
            
        if ($entity instanceof Observation) {
            $id = $entity->getID();
            $fs = new Filesystem();
            
            $userDir = $this->rootDir.'/../uploads/'.$this->tokenStorage->getToken()->getUser()->getId();
            
            $observationsDir = $this->rootDir.'/../web/uploads/'.$id;
            $em = $args->getEntityManager();
            
            foreach(explode(',',$this->request->get('fileuploads')[0]) as $file) {
                $originalFile = $userDir.'/'.$file; 
                if (!empty($file) && $fs->exists($originalFile)) {
                   $fs->copy($originalFile, $observationsDir.'/'.$file);
                   $image = new Image();
                   $image->setFilename('/uploads/'.$id.'/'.$file);
                   //$image->setObservation($entity);
                   $entity->addImage($image);
                   $em->persist($image);
                   //$em->persist($entity);
                   $em->flush();
                   $fs->remove($originalFile);
               }
           }         
        }
    }
}