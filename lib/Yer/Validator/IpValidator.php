<?php

namespace Yer\Validator;

class IpValidator implements ValidatorInterface
{
    protected $config = array(
        'ipv4' => true,
        'ipv6' => false,
    	'local' => true
    );
    
    public function __construct(array $config = array())
    {
        $this->config = array_merge($this->config, $config);
    }
    
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
     * @param  string $value Value to check against
     * @return boolean True when $value is a valid ipv6 address
     *                 False otherwise
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
	 * @param string $ip IP address to check
	 * @return bool
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