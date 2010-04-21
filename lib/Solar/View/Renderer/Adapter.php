<?php

abstract class Solar_View_Renderer_Adapter extends Solar_Base
{
    /**
     *
     * Fetches template output.
     *
     * @param string $name The template to process.
     *
     * @return string The template output.
     *
     */
    abstract public function fetch($name);

    /**
     *
     * Returns the path to the requested template script.
     *
     * @param string $name The template name to look for in the template path.
     *
     * @return string The full path to the template script.
     *
     */
    abstract public function template($name);

    /**
     *
     * Executes a partial template in its own scope, optionally with
     * variables into its within its scope.
     *
     * Note that when you don't need scope separation, using a call to
     * "include $this->template($name)" is faster.
     *
     * @param string $name The partial template to process.
     *
     * @param array|object $spec Additional variables to use within the
     * partial template scope. If an array, we use extract() on it.
     * If an object, we create a new variable named after the partial template
     * file and set that new variable to be the object.  E.g., passing an
     * object to a partial template named `_foo-bar.php` will use that object
     * as `$foo_bar` in the partial.
     *
     * @return string The results of the partial template script.
     *
     */
    abstract public function partial($name, $spec = null);
}
