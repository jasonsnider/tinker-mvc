<?php

/**
 * All an extended controller test really needs to do is call each action to verifiy
 * nothing is causing an error. THe functionality is tested in ControllerTest.
 */
class TinkerPluginControllerTest extends \PHPUnit_Framework_TestCase
{

    private $TinkerPluginController;

    public function __construct()
    {
        $this->Router = \Tinker\Di\IoCRegistry::resolve('Router');
        $this->TinkerPluginController = \Tinker\Di\IoCRegistry::resolve('TinkerPluginController');
        $this->TinkerPluginController->{$this->Router->getAction()}();
    }

    public function testIndex()
    {
        $this->TinkerPluginController->{$this->Router->getAction()}();
    }
}
