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
if(!defined('DS')){
    define('DS', DIRECTORY_SEPARATOR);
}


/**
 * Defines a standard path to application files
 */
if(!defined('APP')){
    define('APP', dirname(dirname(dirname(__FILE__))) . DS . 'App');
}

/**
 * Add core to the existing include path
 */
//set_include_path(get_include_path() . dirname(dirname(__FILE__));

// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require 'Tinker' . DS . 'src' . DS . 'Utility' . DS . 'BuildTime.php';

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

//Load and instantiate, loader and register the auto loader.
require 'vendor' . DS . 'PhpFig' . DS . 'src' . DS . 'Loader.php';

$Loader = new \PhpFig\Loader;
$Loader->register();

//Autoload all files in the Tinker namesspace
$Loader->addNamespace(
    "\MvcInterface", 'Tinker' . DS . 'src' . DS . 'Mvc' . DS . 'Interfaces'
);

//Autoload all files in the Tinker namesspace
$Loader->addNamespace(
    "\Tinker", 'Tinker' . DS . 'src'
);

//Bootstrap the application
require 'test' . DS . 'bootstrap.php';

//Load the runtime configuration
require 'test' . DS . 'configure.php';

//Router
Di\IoCRegistry::register('Router', function(){
    $Router = new Mvc\Router('/tinker_plugin/tinker_plugin/index/e1/e2/e3/e4:1');
    return $Router;
});

$Router = Di\IoCRegistry::resolve('Router');

//View
Di\IoCRegistry::register('View', function() use ($Router, $BuildTime, $Loader) {
    $View = new Mvc\View($Router, $BuildTime, $Loader);
    return $View;
});

$View = Di\IoCRegistry::resolve('View');

//Theme
Di\IoCRegistry::register('Theme', function() use ($Router, $View, $Loader) {
    $View = new \Tinker\Mvc\Theme($Router, $View, $Loader);
    return $View;
});

$Theme = Di\IoCRegistry::resolve('Theme');

// Gather plugins, controllers and actions
// Given the URI /example/main/index/p1/p2/p3/p4:1
// We would be passing 4 GET parameters (where p4 is a named key to value pair and p1 - p3 would be assigned numeric
// keys) into the index action of the main controller of the example plugin.
// The name of the plugin should also be that plugins namespace.
//
// We will predefine 3 possible paths for autoloading:
// 1. Core, the core path will look for a Plugins directory in the core library, this will mostly be used for
// building examples.
// 2. Main, This will check the main plugin path.
// 3. App, This will check the Plugin path inside App. This directory will ship empty by default. I'm assuming this
// is where you will build your application.
// An autoloader will figure out which path to pull from.
//Finally we will istanitate the classes based on the PSR-4 autoloading statndards. This might look something like:
// $class = '\\Example\\Controller\\MainController';
// $Controller = new $class();
// $Controller->index();
//Sample URI /tinker_plugin/tinker_plugin/execute/e1/e2/e3/e4:1

$plugin = $Router->getPlugin(true);
$model = $Router->getPlugin(true);
$controller = $Router->getPlugin(true) . 'Controller';
$action = $Router->getAction();

//Autoload all plugins
$Loader->addNamespace(
    $plugin,
    'plugin' . DS . $plugin . DS . 'src'
);

$Loader->addNamespace(
    $plugin,
    APP . DS . 'plugin' . DS . $plugin . DS . 'src'
);

$Loader->addNamespace(
    'App',
    APP . DS . 'src'
);

//Load custom containers
require 'test' . DS . 'containers.php';

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