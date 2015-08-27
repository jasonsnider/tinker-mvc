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
define('DS', DIRECTORY_SEPARATOR);

/**
 * Defines a standard ROOT file path
 */
define('ROOT', dirname(dirname(dirname(__FILE__))));


// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require ROOT . DS . 'core' . DS . 'Tinker' . DS .
    'src' . DS . 'Utility' . DS . 'BuildTime.php';

$BuildTime = new Utility\BuildTime(microtime());

/**
 * Holds the Loader object
 *
 * @var object
 */
$Loader = null;

/**
 * Holds the Router object
 *
 * @var object
 */
$Router = null;

/**
 * Holds the View object
 *
 * @var object
 */
$View = null;

/**
 * Holds the Theme object
 *
 * @var object
 */
$Theme = null;

/**
 * Holds the Controller object
 *
 * @var object
 */
$Controller = null;

/**
 *
 * @var object
 */
$Model = null;

/**
 *
 * @var string
 */
$plugin = null;

/**
 *
 * @var string
 */
$model = null;

/**
 * Returned from Router, this is the controller being requested
 *
 * @var string
 */
$controller = null;

/**
 * Returned from Router, this is the action to be executed and rendered
 *
 * @var string
 */
$action = null;

//Bootstrap the application
require ROOT . DS . 'core' . DS . 'test' . DS . 'bootstrap.php';

//Load the runtime configuration
require ROOT . DS . 'core' . DS . 'test' . DS . 'configure.php';

//Begin dispatch
require ROOT . DS . 'core' . DS . 'test' . DS . 'dispatch.php';

//Load custom containers
require ROOT . DS . 'core' . DS . 'test' . DS . 'containers.php';

/**
 * A shamfull hack for passing and instance into a unit test
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

/*
if (!empty($Router->checkAsset($Loader))):
    $Router->fetchAsset($Router->checkAsset($Loader));
else:
    //Load the MVC stack, if a specific plugin has not been defined as a container
    //MVC conventions will be used to load the MVC stack
    if (Di\IoCRegistry::registered($controller))
    {
        $Controller = Di\IoCRegistry::resolve($controller);
    } else
    {
        $class = "\\{$plugin}\\Controller\\{$controller}";
        $Model = "\\{$plugin}\\Model\\{$model}";

        $Controller = new $class($Theme, $View, new $Model());
    }

    $Controller->{$action}();
endif;
 */