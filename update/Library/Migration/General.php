<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license see ip_license.html
 */

namespace IpUpdate\Library\Migration;


abstract class General
{

    /**
     * @return \Library\Migration\Result
     */
    public abstract function process();

    /**
     * @return string
     */
    public abstract function getSourceVersion();

    /**
     * @return string
     */
    public abstract function getDestinationVersion();


    public function getDownloadUrl()
    {
        if (!function_exists('curl_init')) {
            throw new \IpUpdate\Library\UpdateException("Can't get download URL", \IpUpdate\Library\UpdateException::CURL_REQUIRED);
        }

        $ch = curl_init();
        
        

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 1800, // set this to 30 min so we dont timeout
            CURLOPT_URL => 'http://service.impresspages.org',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'module_group=service&module_name=communication&action=getVersionInfo&version='.$this->getDestinationVersion()
        );

        curl_setopt_array($ch, $options);
        
        $jsonAnswer = curl_exec($ch);
        
        $answer = json_decode($jsonAnswer);
        
        if ($answer === null) {
            throw new \Exception("Can't get version info about version ".$this->getDestinationVersion().". Server answer: ".$jsonAnswer." ", \IpUpdate\Library\UpdateException::UNKNOWN, array());
        }
        return $answer->downloadUrl;
    }
}