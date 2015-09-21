<?php
/**
 * index.php
 * 
 * The applications entry point. All requests will route through this file.
 * Set Apache's DocumentRoot to point to the webroot directory.
 */

namespace Tinker;

////Initialize startup variables/////

/**
 * Shorthand for DIRECTORY_SEPARATOR
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Defines a standard path to application files
 */
if (!defined('APP')) {
    define('APP', dirname(dirname(dirname(__FILE__))) . DS . 'App');
}

/**
 * Add core to the existing include path
 */
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)) . DS . 'core');

// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require 'Tinker' . DS . 'src' . DS . 'Utility' . DS . 'BuildTime.php';

$BuildTime = new Utility\BuildTime(microtime());

//Bootstrap the application
require 'bootstrap.php';

new Mvc\Dispatcher($Loader, $Router, $Theme, $View, false);

/**
 * A shamfull hack for passing an instance into a unit test
 */
class TestGlobals
{

    /**
     * Holds an array of global variables
     * @var array
     */
    private static $globals = array();

    /**
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function setGlobal($key, $value)
    {
        static::$globals[$key] = $value;
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public static function getGlobal($key)
    {
        return static::$globals[$key];
    }
}

TestGlobals::setGlobal('Loader', $Loader);