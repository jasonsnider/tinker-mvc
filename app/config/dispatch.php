<?php
/**
 * Routing and dispatching
 */

namespace Tinker;

//Router - if a plugin asset is requested, the contents will be written to
//and read from the buffer and execution will be halted.
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