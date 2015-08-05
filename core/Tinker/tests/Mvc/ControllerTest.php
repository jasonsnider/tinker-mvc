<?php

/**
 * Mock the buildTime object
 */
class MockBuildTime{
    public function end(){
        return 1;
    }
}

class TestController extends \Tinker\Mvc\Controller{
    
    public function foo(){}
    
}

class ControllerTest extends \PHPUnit_Framework_TestCase
{

    public function __construct()
    {
        $this->TestController = new TestController(new MockBuildTime());
    }
    
    public function testDestructRendersContent(){
        ob_start();
        $this->TestController->__destruct();
        $this->assertSame('build time: 1', ob_get_contents());
        ob_end_clean();
    }
    

}
