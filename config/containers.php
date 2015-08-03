<?php
/**
 * A configuration file for DI containers.
 */
namespace Tinker;

//Add Router
Di\IoCRegistry::register('Router', function(){
	$Router = new Mvc\Router($_SERVER['REQUEST_URI']);
	return $Router;
});

///// Custom Containers //////