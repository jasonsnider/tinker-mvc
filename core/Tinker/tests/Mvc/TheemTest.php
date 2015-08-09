<?php

class ThemeTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters(){

        $Theme = new \Tinker\Mvc\Theme('router', 'view', 'loader');
        
        $this->assertSame('router', $Theme->Router);
        $this->assertSame('view', $Theme->View);
        $this->assertSame('loader', $Theme->Loader);
    }
    
    public function testSetTheme(){
        $Theme = new \Tinker\Mvc\Theme('router', 'view', 'loader');
        
        $Theme->setTheme('Foo');
        $this->assertSame('Foo', $Theme->getTheme());
    }
    
    public function testSetLayout(){
        $Theme = new \Tinker\Mvc\Theme('router', 'view', 'loader');
        
        $Theme->setLayout('Bar');
        $this->assertSame('Bar', $Theme->getLayout());
    }
    

}
