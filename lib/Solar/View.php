<?php
/**
 *
 * Provides a Template View pattern implementation for Solar.
 *
 * This implementation is good for all (X)HTML and XML template
 * formats, and provides a built-in escaping mechanism for values,
 * along with lazy-loading and persistence of helper objects.
 *
 * Also supports "partial" templates with variables extracted within
 * the partial-template scope.
 *
 * @category Solar
 *
 * @package Solar_View PHP-based TemplateView system.
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: View.php 4405 2010-02-18 04:27:25Z pmjones $
 *
 */
class Solar_View extends Solar_Factory
{
    /**
     *
     * Default configuration values.
     *
     * @config string adapter The adapter class to use.
     *
     * @var array
     *
     */
    protected $_Solar_View = array(
        'adapter' => 'Solar_View_Adapter_Native',
    );
}
