<?php
/**
 * A configuration file for DI containers
 */

namespace Tinker;

///// Custom Containers //////

Di\IoCRegistry::register('ApplicationController', function() use ($plugin, $controller, $model, $Theme, $View) {
    
    $class = "\\{$plugin}\\Controller\\{$controller}";
    $Model = "\\{$plugin}\\Model\\{$model}";

    $Controller = new $class($Theme, $View);
    $Controller->setModel(new $Model());
    
    return $Controller;
});