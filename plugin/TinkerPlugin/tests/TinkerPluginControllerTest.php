<?php
/**
 * All an extended controller test really needs to do is call each action to verifiy
 * nothing is causing an error. THe functionality is tested in ControllerTest.
 */
class TinkerPluginControllerTest extends \PHPUnit_Framework_TestCase
{
    private $action;
    
    private $class;
    
    private $TinkerPluginController;

    public function __construct()
    {
        
        //Get the autoloader going
        $Loader = new \PhpFig\Loader;
        $Loader->register();

        //Autoload all files in the Tinker namesspace
        $Loader->addNamespace(
                "\Tinker", ROOT . DS . 'core' . DS . 'Tinker' . DS . 'src'
        );
        
        //Mock index.php
        $BuildTime = new \Tinker\Utility\BuildTime(microtime());
        $Router = new \Tinker\Mvc\Router('/tinker_plugin/tinker_plugin/index/e1/e2/e3/e4:1');
        $this->View = new \Tinker\Mvc\View($Router, $BuildTime, $Loader);
        $this->Theme = new \Tinker\Mvc\Theme($Router, $this->View, $Loader);

        $plugin = $Router->getPlugin(true);
        $controller = $Router->getPlugin(true) . 'Controller';
        $this->action = $Router->getAction();

        //Autoload all plugins
        $Loader->addNamespace(
            $plugin, ROOT . DS . 'plugin' . DS . $plugin . DS . 'src'
        );
        
        $this->class = "\\{$plugin}\\Controller\\{$controller}";
        $this->TinkerPluginController = new $this->class($this->Theme, $this->View);
    }
    
    public function testIndex(){        
        $this->TinkerPluginController->index();
    }

}
