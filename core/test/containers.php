<?php
/**
 * A configuration file for DI containers
 */

namespace Tinker;

///// Custom Containers //////

Di\IoCRegistry::register('TinkerPluginController', function() use ($plugin, $controller, $model, $Theme, $View) {
    
    $class = "\\{$plugin}\\Controller\\{$controller}";
    $Model = "\\{$plugin}\\Model\\{$model}";

    $Controller = new $class($Theme, $View);
    $Controller->inject(new $Model());
    
    return $Controller;
});