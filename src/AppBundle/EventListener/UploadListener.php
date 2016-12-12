<?php

namespace AppBundle\EventListener;

use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * This class is needed to handle the response after uploading using the jQuery File Upload from BlueImp
 * The bundle Oneup\UploaderBundle does not provide the response after the file upload.
 * 
 *
 */
class UploadListener
{
	protected $key;
	protected $baseUrl;
	protected $session;
	
	public function __construct($key, $baseUrl, Session $session)
	{
		$this->key = $key;
		$this->baseUrl = $baseUrl;
		$this->session = $session;
	}
	
    public function onUpload(PostPersistEvent $event)
    {
    	if ($file = $event->getFile()) {
    		$response = $event->getResponse();
    		$files = array();
    		$files[0] = array(
    				'name' => $file->getFileName(), 		       
    				//'size' => $file->getSize(),
    				'deleteUrl' => '/app_dev.php/user/observations/images/upload/delete?file='.$file->getFileName(),
    		        'deleteType' => 'DELETE',
    				'url'  => NULL,
    				'thumbnail_url' => NULL,
    		);
    		$response['files'] = $files;
    	}
    	
    }
}