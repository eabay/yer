<?php

namespace Yer\Locator;

use Yer\Location;

class GeobytesLocator extends AbstractLocator
{
    protected $email;
    protected $password;
    protected $ssl;
    
    public function __construct($ssl = false, $email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->ssl = (bool) $ssl;
    }
    
    protected function process()
    {
        $uri   = ($this->ssl ? 'https://' : 'http://') . 'www.geobytes.com/IpLocator.htm?GetLocation&';
        $query = array(
            'template'  => 'php3.txt',
            'IpAddress' => $this->ip
        );
        
        if ($this->email && $this->password) {
            $query = array_merge($query, array(
                'pt_email'    => $this->email,
                'pt_password' => $this->password
            ));
        }
        
        $response = get_meta_tags($uri . http_build_query($query));
    	
        if ('Limit Exceeded' == $response['locationcode']) {
        	throw new \Exception('Limit exceeded');
        }
        
        $location = new Location;
        $location
            ->setServiceResponse($response)
            ->setCountryCode($response['iso2'])
            ->setCountryName($response['country'])
            ->setCityName($response['region'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
        ;
        
        $this->setLocation($location);
    }
}