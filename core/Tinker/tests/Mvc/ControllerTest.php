<?php

/**
 * Mock the buildTime object
 */
class MockController extends \Tinker\Mvc\Controller
{

    public function getTheme()
    {
        return $this->Theme;
    }

    public function getView()
    {
        return $this->View;
    }

    public function __destruct()
    {
        
    }

}

class MockModel
{

}

class ControllerTest extends \PHPUnit_Framework_TestCase
{

    private $action;
    private $Controller;

    public function __construct()
    {
        $this->Router = \Tinker\Di\IoCRegistry::resolve('Router');
        $this->Controller = \Tinker\Di\IoCRegistry::resolve('TinkerPluginController');
    }

    public function testDestructRendersContent()
    {

        ob_start();

        $this->Controller->{$this->Router->getAction()}();
        $this->Controller->__destruct();

        $output = ob_get_contents();

        ////Test the theme
        $hasHtmlTag = stripos($output, '<html>') === false ? false : true;
        $noFoobarTag = stripos($output, '<foobar>') === false ? false : true; //Because foobar is not a tag

        $this->assertTrue($hasHtmlTag);
        //Sanity check to make sure the above is not just always returning true
        $this->assertFalse($noFoobarTag);

        ////Test the view
        $welcomeMessage = stripos($output, 'Welcome to TinkerMVC') === false ? false : true; //Text from the view
        $this->assertTrue($welcomeMessage);

        ob_end_clean();
    }

    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters()
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
        $View = new \Tinker\Mvc\View($Router, $BuildTime, $Loader);
        $Theme = new \Tinker\Mvc\Theme($Router, $View, $Loader);

        $mc = new MockController($Theme, $View);
        $mc->setModel(new \TinkerPlugin\Model\TinkerPlugin());
        $mc->setModel(new MockModel());

        //View and Theme setters
        //$this->assertSame(1, $mc->getTheme());
        //$this->assertSame(2, $mc->getView());

        $this->assertTrue(is_object($mc->TinkerPlugin));
        $this->assertTrue(is_object($mc->MockModel));
    }

}
