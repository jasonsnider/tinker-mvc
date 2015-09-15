<?php

namespace Tinker;

class ViewTest extends \PHPUnit_Framework_TestCase
{

    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters()
    {

        //Test against an include path
        $View = new \Tinker\Mvc\View(new Mvc\Router('/'), 'buildtime', 'loader');

        $this->assertInstanceOf('\Tinker\Mvc\Interfaces\Router', $View->Router);
        $this->assertSame('buildtime', $View->BuildTime);
        $this->assertSame('loader', $View->Loader);

        //Test against a defined path
        $Router2 = new Mvc\Router('/application/');
        $Loader2 = TestGlobals::getGlobal('Loader');
        $Loader2->addNamespace(
            'Application',
            APP . DS . 'plugin' . DS . 'Application' . DS . 'src'
        );

        $View2 = new \Tinker\Mvc\View($Router2, 'buildtime', $Loader2);
        
        $this->assertSame(
            '/var/www/tinker-lib/App/plugin/Application/src/View/application/index.php',
            $View2->setViewPath()
        );
    }

}
