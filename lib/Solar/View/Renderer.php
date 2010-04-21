<?php

class Solar_View_Renderer extends Solar_Factory
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
    protected $_Solar_View_Renderer = array(
        'adapter' => 'Solar_View_Renderer_Adapter_Native',
    );
}