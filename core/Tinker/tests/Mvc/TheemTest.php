<?php

class ThemeTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters(){

        $View = new \Tinker\Mvc\Theme('router', 'view', 'loader');
        
        $this->assertSame('router', $View->Router);
        $this->assertSame('view', $View->View);
        $this->assertSame('loader', $View->Loader);
    }
    

}
