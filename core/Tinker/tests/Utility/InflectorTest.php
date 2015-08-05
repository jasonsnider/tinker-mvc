<?php

class InflectorTest extends \PHPUnit_Framework_TestCase
{

    use \Tinker\Utility\Inflector;

    public function teststudlyCaps()
    {
        $string = 'my_controller_class';

        $this->assertSame('MyControllerClass', $this->studlyCaps($string));
    }

}
