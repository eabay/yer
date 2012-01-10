<?php

namespace Yer;

use Yer\Locator\LocatorInterface;
use Yer\Validator\ValidatorInterface;

class Geolocation
{
    /**
     * @var LocatorInterface
     */
    protected $locator;
    
    /**
     * @var ValidatorInterface
     * @return Geolocation
     */
    protected $ipValidator;
    
    public function setLocator(LocatorInterface $locator)
    {
        $this->locator = $locator;
        
        return $this;
    }
    
    /**
     * @param ValidatorInterface $ipValidator
     * @return Geolocation
     */
    public function setIpValidator(ValidatorInterface $ipValidator)
    {
        $this->ipValidator = $ipValidator;
        
        return $this;
    }
    
    /**
     * @param string $ip
     * @return Location
     */
    public function lookup($ip)
    {
        if (!$this->locator) {
            throw new \LogicException('Invalid Geolocation::$locator instance');
        }
        
        if ($this->ipValidator && !$this->ipValidator->validate($ip)) {
            throw new \InvalidArgumentException('Invalid IP address');
        }
        
        return $this->locator->setIp($ip)->getLocation();
    }
}