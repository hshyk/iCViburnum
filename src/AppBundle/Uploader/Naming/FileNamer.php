<?php

namespace AppBundle\Uploader\Naming;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class FileNamer implements NamerInterface
{
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Creates a user directory name for the file being uploaded.
     *
     * @param FileInterface $file
     * @return string The directory name.
     */
    public function name(FileInterface $file)
    {
        $userId = $this->tokenStorage->getToken()->getUser()->getId();
        return sprintf('%s/%s.%s',
            $userId,
            $this->fileNameParser($file->getClientOriginalName()),
            strtolower($file->getExtension())
            );
    }
    
    private function fileNameParser($url)
    {
        $url = rawurlencode($url);
        $url = preg_replace('/\\.[^.\\s]{3,4}$/', '', $url);
        $url = str_replace('%20', '_', $url);
        $url = strtolower($url);
        
        return $url;
        
    }
}