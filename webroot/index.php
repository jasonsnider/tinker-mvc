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
define('ROOT', dirname(dirname(__FILE__)));


// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require dirname(dirname(__FILE__)) . DS . 'core' . DS . 'Tinker' . DS .
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
require ROOT . DS . 'config' . DS . 'bootstrap.php';

//Load the runtime configuration
require ROOT . DS . 'config' . DS . 'configure.php';

//Begin dispatch
require ROOT . DS . 'config' . DS . 'dispatch.php';

//Load custom containers
require ROOT . DS . 'config' . DS . 'containers.php';

//Load the MVC stack, if a specific plugin has not been defined as a container
//MVC conventions will be used to load the MVC stack
if(Di\IoCRegistry::registered($controller)){
    $Controller = Di\IoCRegistry::resolve($controller);
    $Controller->{$action}();
}else{
    $class = "\\{$plugin}\\Controller\\{$controller}";
    $Model = "\\{$plugin}\\Model\\{$model}";

    $Controller = new $class($Theme, $View, new $Model());
    $Controller->{$action}();
}

