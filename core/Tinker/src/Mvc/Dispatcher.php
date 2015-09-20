<?php
/**
 * Dispatcher
 */
namespace Tinker\Mvc;

/**
 * Dispatcher converts a request into a controller action. It uses Router's 
 * mapped request to locate and load the correct controller from the correct
 * plugin. If found the requested action is called on the controller. A 
 * controller action is in the form of Object::method() where the method MUST
 * be public.
 */
class Dispatcher
{

    public function __construct($Loader, $Router, $Theme, $View) {
        
        $plugin = $Router->getPlugin(true);
        $model = $Router->getPlugin(true);
        $controller = $Router->getController(true) . 'Controller';
        $action = $Router->getAction();
        
        if (!empty($Router->checkAsset($Loader))):
            $Router->fetchAsset($Router->checkAsset($Loader));
        else:
            //Load the MVC stack, if a specific plugin has not been defined as a container
            //MVC conventions will be used to load the MVC stack
            if (Di\IoCRegistry::registered($controller)) {
                $Controller = Di\IoCRegistry::resolve($controller);
            } else {
                $class = "\\{$plugin}\\Controller\\{$controller}";
                $Model = "\\{$plugin}\\Model\\{$model}";

                $Controller = new $class($Theme, $View);
                $Controller->inject(new $Model());
            }

            $Controller->{$action}();
        endif;
    }

}