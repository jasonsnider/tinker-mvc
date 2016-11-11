<?php
/**
 * bootstrap.php
 *
 * Bootstraps the application
 */

namespace Tinker;

//Load and instantiate, loader and register the auto loader.
require 'vendor' . DS . 'PhpFig' . DS . 'src' . DS . 'Loader.php';

$Loader = new \PhpFig\Loader;
$Loader->register();

//Autoload all files in the Tinker namespace
$Loader->addNamespace(
    "\MvcInterface", 'Tinker' . DS . 'src' . DS . 'Mvc' . DS . 'Interfaces'
);

//Autoload all files in the Tinker namespace
$Loader->addNamespace(
    "\Tinker", 'Tinker' . DS . 'src'
);

//Load the runtime configuration
require 'configure.php';

//Router
Di\IoCRegistry::register('Router', function() {
    $Router = new Mvc\Router('/tinker_plugin/tinker_plugin/index/e1/e2/e3/e4:1');
    return $Router;
});

$Router = Di\IoCRegistry::resolve('Router');

//View
Di\IoCRegistry::register('View', function() use ($Router, $BuildTime, $Loader) {
    $view = new Mvc\View($Router, $BuildTime, $Loader);
    return $view;
});

$view = Di\IoCRegistry::resolve('View');

//Theme
Di\IoCRegistry::register('Theme', function() use ($Router, $view, $Loader) {
    $view = new \Tinker\Mvc\Theme($Router, $view, $Loader);
    return $view;
});

$Theme = Di\IoCRegistry::resolve('Theme');

//Load custom containers
require 'containers.php';