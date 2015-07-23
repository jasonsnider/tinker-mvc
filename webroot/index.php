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
// I like to know how long things take. Start tracking the serer build time as soon as possible.

//// Bootstrapping
//

//// Dispatching and routing 
// Analyze the pretty url and route the requests
// Instantiate controllers, views and themes (or use auto laoding?)
//
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
echo 'Tinker MVC<br><br>';
