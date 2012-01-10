<?php
/*
 * This file is part of the Yer package.
 * 
 * (c) Erhan Abay <erhanabay@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yer\Validator;

/**
 * Validates an IP address against different configuration options.
 * 
 * @author Erhan Abay <erhanabay@gmail.com>
 */
class IpValidator implements ValidatorInterface
{
    /**
     * Configuration parameters
     * 
     * ipv4  Check IP address against IPv4 pattern
     * ipv6  Check IP address against IPv6 pattern
     * local Check IP address against being a local IP
     * 
     * @var array
     */
    protected $config = array(
        'ipv4' => true,
        'ipv6' => false,
    	'local' => true
    );
    
    /**
     * @see IpValidator::$config
     * 
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge($this->config, $config);
    }
    
    /**
     * Validated given IP address
     * See IpValidator::$config for how it validates 
     * 
     * @param string $value Value to check against
     * 
     * @see ValidatorInterface::validate()
     */
    public function validate($value)
    {
        if (!is_string($value) ||
            ($this->config['local'] && $this->isLocal($value)) ||
            ($this->config['ipv4'] && !$this->config['ipv6'] && !$this->validateIPv4($value)) ||
            (!$this->config['ipv4'] && $this->config['ipv6'] && !$this->validateIPv6($value)) ||
            ($this->config['ipv4'] && $this->config['ipv6'] && !$this->validateIPv4($value) && !$this->validateIPv6($value))
        ) {
            return false;
        }
        
        return true;
    }

    /**
     * Validates an IPv4 address
     *
     * @param string $value
     * 
     * @return boolean true  when $value is a valid ipv6 address
     *                 false otherwise
     */
    protected function validateIPv4($value) {
        $ip2long = ip2long($value);
        if($ip2long === false) {
            return false;
        }

        return $value == long2ip($ip2long);
    }

    /**
     * Validates an IPv6 address
     *
     * @param string $value Value to check against
     * 
     * @return boolean true  when $value is a valid ipv6 address
     *                 false otherwise
     */
    protected function validateIPv6($value) {
        if (strlen($value) < 3) {
            return $value == '::';
        }

        if (strpos($value, '.')) {
            $lastcolon = strrpos($value, ':');
            if (!($lastcolon && $this->validateIPv4(substr($value, $lastcolon + 1)))) {
                return false;
            }

            $value = substr($value, 0, $lastcolon) . ':0:0';
        }

        if (strpos($value, '::') === false) {
            return preg_match('/\A(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}\z/i', $value);
        }

        $colonCount = substr_count($value, ':');
        if ($colonCount < 8) {
            return preg_match('/\A(?::|(?:[a-f0-9]{1,4}:)+):(?:(?:[a-f0-9]{1,4}:)*[a-f0-9]{1,4})?\z/i', $value);
        }

        // special case with ending or starting double colon
        if ($colonCount == 8) {
            return preg_match('/\A(?:::)?(?:[a-f0-9]{1,4}:){6}[a-f0-9]{1,4}(?:::)?\z/i', $value);
        }

        return false;
    }
	
	/**
	 * Detects whether IP address is local or not 
	 *
	 * @param string $ip Value to check against
	 * 
	 * @return boolean true  when $value is a local IP address
     *                 false otherwise
	 */
	protected function isLocal($value)
	{
		$regex = '/(192\.[0-9]{1,3}\.[0-9]\.[0-9]{1,3})';
		$regex .= '|(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})';
		$regex .= '|(172\.0?([1][6-9])¦([2][0-9])¦([3][0-1])\.[0-9]{1,3}\.[0-9]{1,3})';
		$regex .= '|(127\.0\.0\.1)/';
		
		return (bool) preg_match($regex, $value);
	}
}