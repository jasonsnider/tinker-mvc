<?php
/**
 * bootstrap.php
 *
 * Bootstraps the application
 */

namespace Tinker;

//If we are not calling bootstrap.php from the index, the following constants will not be defined.
if (!defined('DS'))
{
    //Shorthand for DIRECTORY_SEPARATOR
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT'))
{
    //Defines a standard ROOT file path
    define('ROOT', dirname(dirname(__FILE__)));
}

//Load and instantiate, loader and register the auto loader.
require ROOT . DS .
    'core' . DS .
    'vendor' . DS .
    'PhpFig' . DS .
    'src' . DS .
    'Loader.php';

$Loader = new \PhpFig\Loader;
$Loader->register();

//Autoload all files in the Tinker namespace
$Loader->addNamespace(
    "\MvcInterface", ROOT . DS . 'core' . DS . 'Tinker' . DS . 'src' . DS . 'Mvc' . DS . 'Interfaces'
);


//Autoload all files in the Tinker namespace
$Loader->addNamespace(
    "\Tinker", ROOT . DS . 'core' . DS . 'Tinker' . DS . 'src'
);