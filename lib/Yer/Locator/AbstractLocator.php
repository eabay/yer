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
 * Abstraction for locator.
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
abstract class AbstractLocator implements LocatorInterface
{
    /**
     * IP address
     * 
     * @var string
     */
    protected $ip;
    
    /**
     * A location instance
     * 
     * @var Yer\Location
     */
    protected $location;
    
    /**
     * Sets IP adress.
     * 
     * @param  string $ip IP address
     * 
     * @return AbstractLocator A locator instance
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        
        return $this;
    }
    
    /**
     * Sets location.
     * 
     * @param  Yer\Location $location A Location instance
     * 
     * @return AbstractLocator A locator instance
     */
    protected function setLocation(Location $location)
    {
        $this->location = $location;
        
        return $this;
    }
    
    /**
     * Runs process if location is not available.
     * 
     * @return Yer\Location A Location instance
     */
    public function getLocation()
    {
        if (!$this->location) {
            $this->process();
        }
        
        return $this->location;
    }
    
    /**
     * Runs lookup and sets location.
     * 
     * @see setLocation()
     */
    abstract protected function process();
}