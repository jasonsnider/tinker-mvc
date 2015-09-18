<?php

class ThemeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * For the sake of complete coverage, make sure depenencies are of the right type
     */
    public function testSetters()
    {

        $Router = new \Tinker\Mvc\Router('/');
        $Theme = new \Tinker\Mvc\Theme($Router, new \Tinker\Mvc\View($Router, 'x', 'x'), 'loader');

        $this->assertInstanceOf('\Tinker\Mvc\Interfaces\Router', $Theme->Router);
        $this->assertInstanceOf('\Tinker\Mvc\Interfaces\View', $Theme->View);
        $this->assertSame('loader', $Theme->Loader);
    }

    public function testSetTheme()
    {

        $Router = new \Tinker\Mvc\Router('/');
        $Theme = new \Tinker\Mvc\Theme($Router, new \Tinker\Mvc\View($Router, 'x', 'x'), 'loader');

        $Theme->setTheme('Foo');
        $this->assertSame('Foo', $Theme->getTheme());
    }

    public function testSetLayout()
    {
        $Router = new \Tinker\Mvc\Router('/');
        $Theme = new \Tinker\Mvc\Theme($Router, new \Tinker\Mvc\View($Router, 'x', 'x'), 'loader');

        $Theme->setLayout('Bar');
        $this->assertSame('Bar', $Theme->getLayout());
    }
}
