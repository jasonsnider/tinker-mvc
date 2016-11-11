<?php
/**
 * A configuration file for DI containers
 */

namespace Tinker;

///// Application Plugin //////

Di\IoCRegistry::register('ApplicationController', function() use (
        $Router, 
        $Theme, 
        $View
    ) {
    
    $plugin = $Router->getPlugin(true);
    $model = $Router->getPlugin(true);
    $controller = $Router->getController(true) . 'Controller';
    
    $class = "\\{$plugin}\\Controller\\{$controller}";
    $model = "\\{$plugin}\\Model\\{$model}";

    $controller = new $class($Theme, $View);
    $controller->inject(new $model());
    
    return $controller;
});

///// Custom Containers //////