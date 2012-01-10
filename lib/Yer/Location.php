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

class Location
{
    protected $serviceResponse;
    protected $countryCode;
    protected $countryName;
    protected $cityCode;
    protected $cityName;
    protected $latitude;
    protected $longitude;
    
	public function setServiceResponse($serviceResponse)
    {
        $this->serviceResponse = $serviceResponse;
        
        return $this;
    }

	public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        
        return $this;
    }

	public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
        
        return $this;
    }

	public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;
        
        return $this;
    }

	public function setCityName($cityName)
    {
        $this->cityName = $cityName;
        
        return $this;
    }

	public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        
        return $this;
    }

	public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        
        return $this;
    }
    
	public function getServiceResponse()
    {
        return $this->serviceResponse;
    }

	public function getCountryCode()
    {
        return $this->countryCode;
    }

	public function getCountryName()
    {
        return $this->countryName;
    }

	public function getCityCode()
    {
        return $this->cityCode;
    }

	public function getCityName()
    {
        return $this->cityName;
    }

	public function getLatitude()
    {
        return $this->latitude;
    }

	public function getLongitude()
    {
        return $this->longitude;
    }
}