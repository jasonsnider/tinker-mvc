<?php

/**
 * A unit test for configure
 */
class ConfigureTest extends \PHPUnit_Framework_TestCase
{

    public function testReadAll()
    {
        $this->assertTrue(!empty(\Tinker\Configure::read()));
    }

    public function testReadVar()
    {
        $this->assertSame('TinkerPlugin', \Tinker\Configure::read('theme'));
    }

    /**
     *
     * @expectedException Exception
     */
    public function testThrowsExceptionAVarIsAlreadySet()
    {
        \Tinker\Configure::write('theme', 'foobar');
    }

    public function testSetsVar()
    {
        $this->assertTrue(empty(\Tinker\Configure::read('foo')));
        \Tinker\Configure::write('foo', 'bar');
        $this->assertSame('bar', \Tinker\Configure::read('foo'));
    }
}
