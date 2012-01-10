<?php
/*
 * This file is part of the Yer package.
 * 
 * (c) Erhan Abay <erhanabay@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yer;

use Yer\Locator\LocatorInterface;
use Yer\Validator\ValidatorInterface;

/**
 * Geolocation is a factory class.
 * 
 * You can setup locator and validator instances
 * and run a lookup. Ip validator is optional
 * 
 * Usage:
 * 
 * $geolocation = new Geolocation;
 * $geolocation
 *     ->setLocator(new MaxMindWebServiceLocator('your license key'))
 *     ->setIpValidator(new IpValidator)
 * ;
 * 
 * var_dump($geolocation->lookup('ip address'));
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
class Geolocation
{
    /**
     * @var Yer\Locator\LocatorInterface
     */
    protected $locator;
    
    /**
     * @var Yer\Validator\ValidatorInterface
     */
    protected $ipValidator;
    
    /**
     * Sets locator instance
     * 
     * @param  Yer\Locator\LocatorInterface $locator
     * @return Yer\Geolocation
     */
    public function setLocator(LocatorInterface $locator)
    {
        $this->locator = $locator;
        
        return $this;
    }
    
    /**
     * Sets IP validator instance
     * 
     * @param  Yer\Locator\LocatorInterface $ipValidator
     * @return Yer\Geolocation
     */
    public function setIpValidator(ValidatorInterface $ipValidator)
    {
        $this->ipValidator = $ipValidator;
        
        return $this;
    }
    
    /**
     * Gets results from locator instance for IP address
     * 
     * @param  string $ip IP address
     * @return Yer\Location
     * 
     * @throws \LogicException When locator instance is not set
     * @throws \InvalidArgumentException When IP address validation failed
     */
    public function lookup($ip)
    {
        if (!$this->locator) {
            throw new \LogicException('Invalid locator instance');
        }
        
        if ($this->ipValidator && !$this->ipValidator->validate($ip)) {
            throw new \InvalidArgumentException('Invalid IP address');
        }
        
        return $this->locator->setIp($ip)->getLocation();
    }
}