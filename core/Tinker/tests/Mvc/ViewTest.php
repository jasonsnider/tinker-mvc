<?php namespace Tinker;

class ViewTest extends \PHPUnit_Framework_TestCase
{

    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters()
    {

        //Test against an include path
        $view = new \Tinker\Mvc\View(new Mvc\Router('/'), 'buildtime', 'loader');

        $this->assertInstanceOf('\Tinker\Mvc\Interfaces\Router', $view->Router);
        $this->assertSame('buildtime', $view->BuildTime);
        $this->assertSame('loader', $view->Loader);

        //Test against a defined path
        $Router2 = new Mvc\Router('/application/');
        $Loader2 = TestGlobals::getGlobal('Loader');
        $Loader2->addNamespace(
            'Application', APP . DS . 'plugin' . DS . 'Application' . DS . 'src'
        );

        $view2 = new \Tinker\Mvc\View($Router2, 'buildtime', $Loader2);

        $this->assertSame(
            APP . DS .
            'plugin' . DS . 
            'Application' . DS . 
            'src' . DS . 
            'View' . DS . 
            'application' . DS . 
            'index.php', 
            $view2->setViewPath()
        );
    }
}
