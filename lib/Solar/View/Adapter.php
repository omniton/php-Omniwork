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
abstract class Solar_View_Adapter extends Solar_Base
{
    /**
     *
     * Default configuration values.
     *
     * @config array template_path The paths to view template directories.
     *
     * @config array helper_class A stack of helper class prefixes.
     *
     * @config array escape Keys for 'quotes' and 'charset' to use when
     * escaping template values; cf. the [[Solar_View::$_escape]] property.
     *
     * @var array
     *
     */
    protected $_Solar_View_Adapter = array(
        'template_path' => array(),
        'helper_class'  => array(),
        'escape'        => array(),
    );

    /**
     *
     * Parameters for escaping.
     *
     * @var array
     *
     */
    protected $_escape = array(
        'quotes'  => ENT_COMPAT,
        'charset' => 'UTF-8',
    );

    /**
     *
     * Instantiated helper objects.
     *
     * @var array
     *
     */
    protected $_helper = array();

    /**
     *
     * Class stack for helpers.
     *
     * @var Solar_Class_Stack
     *
     */
    protected $_helper_class;

    /**
     *
     * The name of the current partial file.
     *
     * @var string
     *
     */
    protected $_partial_file;

    /**
     *
     * Variables to be extracted within a partial.
     *
     * @var array
     *
     */
    protected $_partial_vars;

    /**
     *
     * The name of the current template file.
     *
     * @var string
     *
     */
    protected $_template_file;

    /**
     *
     * Path stack for templates.
     *
     * @var Solar_Path_Stack
     *
     */
    protected $_template_path;

    /**
     *
     * Post-construction tasks to complete object construction.
     *
     * @return void
     *
     */
    protected function _postConstruct()
    {
        parent::_postConstruct();

        // set the fallback helper path
        $this->_helper_class = Solar::factory('Solar_Class_Stack');
        $this->setHelperClass($this->_config['helper_class']);

        // set the fallback template path
        $this->_template_path = Solar::factory('Solar_Path_Stack');
        $this->setTemplatePath($this->_config['template_path']);

        // special setup
        $this->_setup();
    }

    /**
     *
     * Disallows setting of underscore-prefixed variables.
     *
     * @param string $key The variable name.
     *
     * @param string $val The variable value.
     *
     * @return void
     *
     */
    public function __set($key, $val)
    {
        if ($key[0] != '_') {
            $this->$key = $val;
        }
    }

    /**
     *
     * Allows specialized setup for extended classes.
     *
     * @return void
     *
     */
    protected function _setup()
    {
        if (! empty($this->_config['escape']['quotes'])) {
            $this->_escape['quotes'] = $this->_config['escape']['quotes'];
        }
        if (! empty($this->_config['escape']['charset'])) {
            $this->_escape['charset'] = $this->_config['escape']['charset'];
        }
    }

    /**
     *
     * Sets variables for the view.
     *
     * This method is overloaded; you can assign all the properties of
     * an object, an associative array, or a single value by name.
     *
     * You are not allowed to assign any variable with an underscore
     * prefix.
     *
     * In the following examples, the template will have two variables
     * assigned to it; the variables will be known inside the template as
     * "$this->var1" and "$this->var2".
     *
     * {{code: php
     *     $view = Solar::factory('Solar_View_Template');
     *
     *     // assign directly
     *     $view->var1 = 'something';
     *     $view->var2 = 'else';
     *
     *     // assign by associative array
     *     $ary = array('var1' => 'something', 'var2' => 'else');
     *     $view->assign($ary);
     *
     *     // assign by object
     *     $obj = new stdClass;
     *     $obj->var1 = 'something';
     *     $obj->var2 = 'else';
     *     $view->assign($obj);
     *
     *     // assign by name and value
     *     $view->assign('var1', 'something');
     *     $view->assign('var2', 'else');
     * }}
     *
     * @param mixed $spec The assignment specification.
     *
     * @param mixed $var (Optional) If $spec is a string, assign
     * this variable to the $spec name.
     *
     * @return bool True on success, false on failure.
     *
     */
    public function assign($spec, $var = null)
    {
        // assign from associative array
        if (is_array($spec)) {
            foreach ($spec as $key => $val) {
                $this->$key = $val;
            }
            return true;
        }

        // assign from Solar_View object properties.
        //
        // objects of a class have access to the protected and
        // private properties of other objects of the same class.
        // this means get_object_vars() will get all the internals
        // of the assigned Solar_View object, overwriting the
        // internals of this object.  check for underscores to make
        // sure we don't do this.  yes, this means we check both
        // here and at __set(), which sucks.
        if (is_object($spec) && $spec instanceof Solar_View) {
            foreach (get_object_vars($spec) as $key => $val) {
                if ($key[0] != "_") {
                    $this->$key = $val;
                }
            }
            return true;
        }

        // assign from object properties (not Solar_View)
        if (is_object($spec)) {
            foreach (get_object_vars($spec) as $key => $val) {
                $this->$key = $val;
            }
            return true;
        }

        // assign by name and value
        if (is_string($spec)) {
            $this->$spec = $var;
            return true;
        }

        // $spec was not array, object, or string.
        return false;
    }

    // -----------------------------------------------------------------
    //
    // Helpers
    //
    // -----------------------------------------------------------------

    /**
     *
     * Executes a helper method with arbitrary parameters.
     *
     * @param string $name The helper name.
     *
     * @param array $args The parameters passed to the helper.
     *
     * @return string The helper output.
     *
     */
    public function __call($name, $args)
    {
        $helper = $this->getHelper($name);
        return call_user_func_array(array($helper, $name), $args);
    }

    /**
     *
     * Reset the helper class stack.
     *
     * @param string|array $list The classes to set for the stack.
     *
     * @return void
     *
     * @see Solar_Class_Stack::set()
     *
     * @see Solar_Class_Stack::add()
     *
     */
    public function setHelperClass($list = null)
    {
        $parents = Solar_Class::parents($this, true);
        array_shift($parents); // drops Solar_Base
        foreach ($parents as $key => $val) {
            $parents[$key] = $val . '_Helper';
        }
        $this->_helper_class->set($parents);
        $this->_helper_class->add($list);
    }

    /**
     *
     * Add to the helper class stack.
     *
     * @param string|array $list The classes to add to the stack.
     *
     * @return void
     *
     * @see Solar_Class_Stack::add()
     *
     */
    public function addHelperClass($list)
    {
        $this->_helper_class->add($list);
    }

    /**
     *
     * Returns the helper class stack.
     *
     * @return array The stack of helper classes.
     *
     * @see Solar_Class_Stack::get()
     *
     */
    public function getHelperClass()
    {
        return $this->_helper_class->get();
    }

    /**
     *
     * Returns an internal helper object; creates it as needed.
     *
     * @param string $name The helper name.  If this helper has not
     * been created yet, this method creates it after loading it from
     * the helper class stack.
     *
     * @return object An internal helper object.
     *
     */
    public function getHelper($name)
    {
        $name[0] = strtolower($name[0]);
        if (empty($this->_helper[$name])) {
            $this->_helper[$name] = $this->newHelper($name);
        }
        return $this->_helper[$name];
    }

    /**
     *
     * Creates a new standalone helper object.
     *
     * @param string $name The helper name.
     *
     * @param array $config Configuration value overrides, if any.
     *
     * @return object A new standalone helper object.
     *
     * @see Solar_Class_Stack::load()
     *
     */
    public function newHelper($name, $config = null)
    {
        $name[0] = strtolower($name[0]);
        $class = $this->_helper_class->load($name);
        settype($config, 'array');
        $config['_view'] = $this;
        $helper = new $class($config);
        return $helper;
    }

    /**
     *
     * Built-in helper for escaping output.
     *
     * @param scalar $value The value to escape.
     *
     * @return string The escaped value.
     *
     */
    public function escape($value)
    {
        return htmlspecialchars(
        $value,
        $this->_escape['quotes'],
        $this->_escape['charset']
        );
    }

    // -----------------------------------------------------------------
    //
    // Templates and partials
    //
    // -----------------------------------------------------------------

    /**
     *
     * Reset the template directory path stack.
     *
     * @param string|array $path The directories to set for the stack.
     *
     * @return void
     *
     * @see Solar_Path_Stack::set()
     *
     */
    public function setTemplatePath($path = null)
    {
        return $this->_template_path->set($path);
    }

    /**
     *
     * Add to the template directory path stack.
     *
     * @param string|array $path The directories to add to the stack.
     *
     * @return void
     *
     * @see Solar_Path_Stack::add()
     *
     */
    public function addTemplatePath($path)
    {
        return $this->_template_path->add($path);
    }

    /**
     *
     * Returns the template directory path stack.
     *
     * @return array The path stack of template directories.
     *
     * @see Solar_Path_Stack::get()
     *
     */
    public function getTemplatePath()
    {
        return $this->_template_path->get();
    }

    public function getTheme()
    {
        return $this->_config['theme'];
    }

    /**
     *
     * Displays a template directly.
     *
     * @param string $name The template to display.
     *
     * @return void
     *
     */
    public function display($name)
    {
        echo $this->fetch($name);
    }

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
