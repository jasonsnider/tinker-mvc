<?php

/**
 * index.php
 * 
 * The applications entry point. All requests will route through this file.
 * Set Apache's DocumentRoot to point to the webroot directory.
 */

namespace Tinker;

/**
 * Shorthand for DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Defines a standard ROOT file path
 */
define('ROOT', dirname(dirname(__FILE__)));

//// Build time
require ROOT . DS . 'core' . DS . 'Tinker' . DS . 'src' . DS . 'Utility' . DS . 'BuildTime.php';

$BuildTime = new Utility\BuildTime(microtime());

//// Bootstrapping
require ROOT . DS . 'config' . DS . 'bootstrap.php';

//// Dispatching and routing 
// Analyze the pretty url and route the requests
// Instantiate controllers, views and themes (or use auto laoding?)

$Router = new Mvc\Router($_SERVER['REQUEST_URI']);

$View = new \Tinker\Mvc\View($Router, $BuildTime, $Loader);
$Theme = new \Tinker\Mvc\Theme($Router, $View, $Loader);

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
    $plugin, ROOT . DS . 'core' .  DS . 'plugin' . DS . $plugin . DS . 'src'
);
        
$Loader->addNamespace(
    $plugin, ROOT . DS . 'plugin' . DS . $plugin . DS . 'src'
);

$class = "\\{$plugin}\\Controller\\{$controller}";
$Model = "\\{$plugin}\\Model\\{$model}";

$Controller = new $class($Theme, $View, new $Model());
$Controller->{$action}();