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
    /**
     * Loader
     *
     * @var object
     */
    protected $Loader;

    /**
     * Router
     *
     * @var object
     */
    protected $Router;

    /**
     * Theme
     *
     * @var object
     */
    protected $Theme;

    /**
     * View
     *
     * @var object
     */
    protected $View;

    /**
     * Gather plugins, controllers and actions
     * Given the URI /example/main/index/p1/p2/p3/p4:1
     * We would be passing 4 GET parameters (where p4 is a named key to value
     * pair and p1 - p3 would be assigned numeric keys) into the index action of
     * the main controller of the example plugin.
     *
     * The name of the plugin should also be that plugins namespace.
     *
     * We will predefine 3 possible paths for autoloading:
     * 1. Core, the core path will look for a Plugins directory in the core
     *
     * library, this will mostly be used for building examples.
     * 2. Main, This will check the main plugin path.
     *
     * 3. App, This will check the Plugin path inside App. This directory will
     * ship empty by default. I'm assuming this is where you will build your
     * application.
     *
     * An autoloader will figure out which path to pull from.
     * Finally we will istanitate the classes based on the PSR-4 autoloading
     * statndards. This might look something like:
     *
     * $class = '\\Example\\Controller\\MainController';
     * $Controller = new $class();
     * $Controller->index();
     *
     * Sample URI /tinker_plugin/tinker_plugin/execute/e1/e2/e3/e4:1
     *
     * @param object $loader
     * @param object $router
     * @param object $theme
     * @param object $view
     * @param boolean $render (set to false for unit testing)
     * @return void
     */
    public function __construct($loader, $router, $theme, $view, $render = true) {

        $this->Loader = $loader;
        $this->Router = $router;
        $this->Theme = $theme;
        $this->View = $view;

        $plugin = $this->Router->getPlugin(true);
        $model = $this->Router->getPlugin(true);
        $controller = $this->Router->getController(true) . 'Controller';
        $action = $this->Router->getAction();

        //Autoload all plugins
        $this->Loader->addNamespace(
            $plugin,
            'plugin' . DS . $plugin . DS . 'src'
        );

        $this->Loader->addNamespace(
            $plugin,
            APP . DS . 'plugin' . DS . $plugin . DS . 'src'
        );

        $this->Loader->addNamespace(
            'App',
            APP . DS . 'src'
        );

        if($render){
            if (!empty($this->Router->checkAsset($Loader))):
                $this->Router->fetchAsset($this->Router->checkAsset($Loader));
            else:
                //Load the MVC stack, if a specific plugin has not been defined as
                //a container MVC conventions will be used to load the MVC stack
                if (\Tinker\Di\IoCRegistry::registered($controller)) {
                    $Controller = \Tinker\Di\IoCRegistry::resolve($controller);
                } else {
                    $class = "\\{$plugin}\\Controller\\{$controller}";
                    $Model = "\\{$plugin}\\Model\\{$model}";

                    $Controller = new $class($this->Theme, $this->View);
                    $Controller->inject(new $Model());
                }

                $Controller->{$action}();
            endif;
        }

    }

}
