<?php

namespace Yer\Locator;

use Yer\Location;
use Yer\Validator\ValidatorInterface;

abstract class AbstractLocator implements LocatorInterface
{
    protected $ip;
    protected $location;
    
    public function setIp($ip)
    {
        $this->ip = $ip;
        
        return $this;
    }
    
    protected function setLocation(Location $location)
    {
        $this->location = $location;
        
        return $this;
    }
    
    public function getLocation()
    {
        if (!$this->location) {
            $this->process();
        }
        
        return $this->location;
    }
    
    abstract protected function process();
}