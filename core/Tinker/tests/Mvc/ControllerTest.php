<?php

/**
 * Mock the buildTime object
 */
class MockController extends \Tinker\Mvc\Controller{
    
    public function __construct($Theme, $View)
    {
        parent::__construct($Theme, $View);
        $this->setView($View);
        $this->setTheme($Theme);
    }
    
    public function getTheme(){
        return $this->Theme;
    }
    
    public function getView(){
        return $this->View;
    }
    
    public function __destruct(){}
}

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    
    private $action;
    
    private $class;
    
    private $Controller;

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
        $BuildTime = new \Tinker\Utility\BuildTime();
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
        $this->Controller = new $this->class($this->Theme, $this->View);
        
        $this->MockController = new MockController($this->Theme, $this->View);
    }
    
    public function testDestructRendersContent(){

        ob_start();
        
        //$this->Controller->{$this->action}();
        $this->Controller->__destruct();
        
        $output = ob_get_contents();
        
        ////Test the theme
        $hasHtmlTag = stripos($output, '<html>') === false?false:true;
        $noFoobarTag = stripos($output, '<foobar>') === false?false:true; //Because foobar is not a tag
        
        $this->assertTrue($hasHtmlTag);
        //Sanity check to make sure the above is not just always returning true
        $this->assertFalse($noFoobarTag);
        
        ////Test the view
        $welcomeMessage = stripos($output, 'Welcome to TinkerMVC') === false?false:true; //Text from the view
        $this->assertTrue($welcomeMessage);
        
        ob_end_clean();
    }
    
    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters(){

        $mc = new MockController(1, 2);
        
        $this->assertSame(1, $mc->getTheme());
        $this->assertSame(2, $mc->getView());
    }
    

}
