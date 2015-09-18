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
