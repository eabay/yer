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

/**
 * A locator returns geographic location information of an IP address
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
interface LocatorInterface
{
    /**
     * Sets IP adress.
     * 
     * @param  string $ip IP address
     * 
     * @return LocatorInterface A locator instance
     */
    public function setIp($ip);
    
    /**
     * Returns location information
     * 
     * @return Yer\Location A Location instance
     */
    public function getLocation();
}