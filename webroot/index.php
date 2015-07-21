<?php
/**
 * index.php
 * 
 * The applications entry point. All requests will route through this file.
 * Set Apache's DocumentRoot to point to the webroot directory.
 */
namespace Tinker;

/**
 * @const string Shorthand for DIRECTORY_SEPARATOR
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * @const string Defines a standard ROOT file path
 */
define('ROOT', dirname(dirname(__FILE__)));
