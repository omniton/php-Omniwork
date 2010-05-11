<?php
/**
 *
 * Log adapter to ignore all messages.
 *
 * @category Solar
 *
 * @package Solar_Log
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: None.php 3153 2008-05-05 23:14:16Z pmjones $
 *
 */
class Solar_Log_Adapter_Syslog extends Solar_Log_Adapter
{
    protected $_Solar_Log_Adapter_Syslog = array(
        'ident' => 'Solar',
        'options' => LOG_ODELAY,
        'facility' => LOG_LOCAL0,
        'events' => array(
    LOG_EMERG, LOG_ALERT, LOG_CRIT, LOG_ERR, LOG_WARNING, LOG_NOTICE, LOG_INFO, LOG_DEBUG),
    );

    protected function _postConstruct()
    {
        parent::_postConstruct();
        openlog($this->_config['ident'], $this->_config['options'], $this->_config['facility']);
    }

    protected function _save($class, $event, $descr)
    {
        return syslog($event, $class . ': ' . $descr);
    }
}
