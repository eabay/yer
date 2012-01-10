<?php

namespace Yer\Locator;

interface LocatorInterface
{
    public function setIp($ip);
    
    public function getLocation();
}