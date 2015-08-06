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
        $output = ob_get_contents();
        $hasHtmlTag = stripos($output, '<html>') === false?false:true;
        $noFoobarTag = stripos($output, '<foobar>') === false?false:true; //Because foobar is not a tag
        $this->assertTrue($hasHtmlTag);
        //Sanity check to make sure the above is not just always returning true
        $this->assertFalse($noFoobarTag);
        ob_end_clean();
    }
    

}
