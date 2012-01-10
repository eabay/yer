<?php

namespace Yer\Locator;

use Yer\Location;

class MaxMindWebServiceLocator extends AbstractLocator
{
    protected $license;
    
    /**
     * List of error codes returned by service
     * @link http://www.maxmind.com/app/web_services_codes
     */
    const IP_NOT_FOUND              = 'IP_NOT_FOUND';
    const IP_REQUIRED               = 'IP_REQUIRED';
    const INVALID_LICENSE_KEY       = 'INVALID_LICENSE_KEY';
    const LICENSE_REQUIRED          = 'LICENSE_REQUIRED';
    const MAX_REQUESTS_PER_LICENSE  = 'MAX_REQUESTS_PER_LICENSE';
    
    /**
     * Error messages
     * 
     * @var array
     */
    protected $messages = array(
        self::IP_NOT_FOUND             => 'Ip not found',
        self::IP_REQUIRED              => 'Ip required',
        self::INVALID_LICENSE_KEY      => 'Invalid license key',
        self::LICENSE_REQUIRED         => 'License required',
        self::MAX_REQUESTS_PER_LICENSE => 'Max requests per license reached'
    );
    
    public function __construct($license)
    {
        $this->license = $license;
    }
    
    protected function process()
    {
        $response = file_get_contents('http://geoip3.maxmind.com/f?' . http_build_query(array(
            'l' => $this->license,
            'i' => $this->ip
        )));
        
        $response = iconv('ISO-8859-1', 'UTF-8', $response);
    	
        $values = preg_split('/,(?!\s+)/', $response);
        
        array_walk($values, function(&$value) {
        	$value = str_replace("\"", "", $value);
        	$value = empty($value) || $value == '(null)' ? null : $value;
        });
        
        if (isset($values[10])) {
            $message = key_exists($values[10], $this->messages) ? $this->messages[$values[10]] : $values[5];
        	
        	throw new \Exception("Service response: '$message'");
        }
        
        $location = new Location;
        $location
            ->setServiceResponse($response)
            ->setCountryCode($values[0])
            ->setCityCode($values[1])
            ->setCityName($values[2])
            ->setLatitude($values[4])
            ->setLongitude($values[5])
        ;
        
        $this->setLocation($location);
    }
}