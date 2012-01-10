<?php
/*
 * This file is part of the Yer package.
 * 
 * (c) Erhan Abay <erhanabay@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yer\Locator;

use Yer\Location;

/**
 * Locator class for geobytes.com
 * 
 * @link http://www.geobytes.com/
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
class GeobytesLocator extends AbstractLocator
{
    /**
     * Email address for geobytes.com authentication
     * 
     * @var string
     */
    protected $email;
    
    /**
     * Password address for geobytes.com authentication
     * 
     * @var string
     */
    protected $password;
    
    /**
     * Turn on/off SSL
     * 
     * @var boolean
     */
    protected $ssl;
    
    /**
     * 
     * Contructor
     * 
     * @param boolean $ssl      Turn on/off SSL
     * @param string  $email    Email address for geobytes.com authentication
     * @param string  $password Password address for geobytes.com authentication
     */
    public function __construct($ssl = false, $email = null, $password = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->ssl = (bool) $ssl;
    }
    
    /**
     * @see AbstractLocator::process()
     */
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