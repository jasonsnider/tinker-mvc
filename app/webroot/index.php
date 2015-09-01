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

/**
 * Defines a standard path to the tinker core lib
 */
define('CORE', ROOT . DS . 'core');

/**
 * Defines a standard path to application files
 */
define('APP', ROOT . DS . 'app');

// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require CORE . DS . 'Tinker' . DS .
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
require APP . DS . 'config' . DS . 'bootstrap.php';

//Load the runtime configuration
require APP . DS . 'config' . DS . 'configure.php';


// Router
Di\IoCRegistry::register('Router', function(){
    $Router = new Mvc\Router($_SERVER['REQUEST_URI']);
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
$controller = $Router->getController(true) . 'Controller';
$action = $Router->getAction();

//Autoload all plugins
$Loader->addNamespace(
    $plugin, CORE . DS . 'plugin' . DS . $plugin . DS . 'src'
);

$Loader->addNamespace(
    $plugin, APP . DS . 'plugin' . DS . $plugin . DS . 'src'
);

//Load custom containers
require APP . DS . 'config' . DS . 'containers.php';

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

        $Controller = new $class($Theme, $View);
        $Controller->setModel(new $Model());
    }

    $Controller->{$action}();
endif;