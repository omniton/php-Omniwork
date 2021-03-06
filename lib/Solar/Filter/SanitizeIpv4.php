<?php
/**
 *
 * Sanitizes a value to an IPv4 address.
 *
 * @category Solar
 *
 * @package Solar_Filter
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: SanitizeIpv4.php 3732 2009-04-29 17:27:56Z pmjones $
 *
 */
class Solar_Filter_SanitizeIpv4 extends Solar_Filter_Abstract
{
    /**
     *
     * Forces the value to an IPv4 address.
     *
     * @param mixed $value The value to be sanitized.
     *
     * @return string The sanitized value.
     *
     */
    public function sanitizeIpv4($value)
    {
        // if the value is not required, and is blank, sanitize to null
        $null = ! $this->_filter->getRequire() &&
        $this->_filter->validateBlank($value);

        if ($null) {
            return null;
        }

        // normal sanitize
        return long2ip(ip2long($value));
    }
}