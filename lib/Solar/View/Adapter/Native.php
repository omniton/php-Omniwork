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
class Solar_View_Adapter_Native extends Solar_View_Adapter
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
    public function fetch($name)
    {
        // save externally and unset from local scope
        $this->_template_file = $this->template($name);
        unset($name);

        // run the template
        ob_start();
        require $this->_template_file;
        return ob_get_clean();
    }

    /**
     *
     * Returns the path to the requested template script.
     *
     * @param string $name The template name to look for in the template path.
     *
     * @return string The full path to the template script.
     *
     */
    public function template($name)
    {
        // append ".php" if needed
        if (substr($name, -4) != '.php') {
            $name .= '.php';
        }

        // get a path to the template
        $file = $this->_template_path->find($name);

        // could we find it?
        if (! $file) {
            throw $this->_exception('ERR_TEMPLATE_NOT_FOUND', array(
                'name' => $name,
                'path' => $this->_template_path->get()
            ));
        }

        // done!
        return $file;
    }

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
    public function partial($name, $spec = null)
    {
        // use a try/catch block so that if a partial is not found, the
        // exception does not break the parent template.
        try {
            // save the partial name externally
            $this->_partial_file = $this->template($name);
        } catch (Solar_View_Exception_TemplateNotFound $e) {
            throw $this->_exception('ERR_PARTIAL_NOT_FOUND', $e->getInfo());
        }

        // save partial vars externally. special cases for different types.
        if (is_object($spec)) {

            // the object var name is based on the partial's template name.
            // e.g., `foo/_bar-baz.php` becomes `$bar_baz`.
            $key = basename($this->_partial_file); // file name
            $key = substr($key, 1); // drop leading underscore
            if (substr($key, -4) == '.php') {
                $key = substr($key, 0, -4); // drop trailing .php
            }
            $key = str_replace('-', '_', $key); // convert dashes to underscores

            // keep the object under the key name
            $this->_partial_vars[$key] = $spec;

            // remove the key name from the local scope
            unset($key);

        } else {
            // keep vars as an array to be extracted
            $this->_partial_vars = (array) $spec;
        }

        // remove the partial name and spec from local scope
        unset($name);
        unset($spec);

        // disallow resetting of $this
        unset($this->_partial_vars['this']);

        // inject vars into local scope
        extract($this->_partial_vars);

        // run the partial template
        ob_start();
        require $this->_partial_file;
        return ob_get_clean();
    }
}
