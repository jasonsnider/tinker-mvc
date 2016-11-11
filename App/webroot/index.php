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
 * Defines a standard path to application files
 */
define('APP', dirname(dirname(__FILE__)));

/**
 * Add core to the existing include path
 */
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(dirname(__FILE__))) . DS . 'core');

// Build time
// Record the current microtime, rendering the view will capture the diff
// between now and the ~end of rendering
require 'Tinker' . DS . 'src' . DS . 'Utility' . DS . 'BuildTime.php';

$BuildTime = new Utility\BuildTime(microtime());

//Bootstrap the application
require APP . DS . 'config' . DS . 'bootstrap.php';

new Mvc\Dispatcher($Loader, $Router, $Theme, $view);