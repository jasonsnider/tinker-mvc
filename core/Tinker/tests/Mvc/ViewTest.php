<?php

namespace Tinker;

class ViewTest extends \PHPUnit_Framework_TestCase
{

    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters()
    {

        $View = new \Tinker\Mvc\View(new Mvc\Router('/'), 'buildtime', 'loader');

        $this->assertInstanceOf('\Tinker\Mvc\Interfaces\Router', $View->Router);
        $this->assertSame('buildtime', $View->BuildTime);
        $this->assertSame('loader', $View->Loader);
    }

}
