<?php
class Solar_Plugin extends Solar_Base
{
    protected $_Solar_Plugin = array();

    const
    EXECUTE_ALL = 0,
    EXECUTE_WHILE_TRUE = 1,
    EXECUTE_WHILE_FALSE = 2;

    static $_pluginObjects = array();

    public function execute($controller, $event, $params = array(), $type = self::EXECUTE_ALL)
    {
        if (!is_object($controller) || empty($event)) return false;

        switch ($type) {
            case self::EXECUTE_WHILE_FALSE:
                $return = false;
                break;
            case self::EXECUTE_WHILE_TRUE:
                $return = true;
                break;
            default:
            case self::EXECUTE_ALL:
                $return = array();
        }
        $plugins = array_value($this->_config, get_class($controller));

        foreach ((array)$plugins as $plugin) {
            if (array_value($plugin, array('events_map', $event)) && !empty($plugin['class'])) {
                if (empty(Solar_Plugin::$_pluginObjects[$plugin['class']])) {
                    $obj = Solar::factory($plugin['class'], array_value($plugin, 'config'));
                    Solar_Plugin::$_pluginObjects[$plugin['class']] = $obj;
                } else {
                    $obj = Solar_Plugin::$_pluginObjects[$plugin['class']];
                }

                // execute plugin for each subevent
                foreach ((array)$plugin['events_map'][$event] as $subEvent) {
                    $result = $obj->execute($controller, $subEvent, $params);

                    switch ($type) {
                        case self::EXECUTE_ALL:
                            $return[$plugin['class']] = $result;
                            break;
                        case self::EXECUTE_WHILE_FALSE:
                            if ($result) return $result;
                        case self::EXECUTE_WHILE_TRUE:
                            if (!$result) return $result;
                    }
                }
            }
        }
        return $return;
    }
}