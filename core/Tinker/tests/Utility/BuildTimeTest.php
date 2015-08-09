<?php

class BuildTimeTest extends \PHPUnit_Framework_TestCase
{

    public function testBuildTime()
    {
        $bt = new \Tinker\Utility\BuildTime('0.30959900 1439136999');
        $this->assertSame(0.00071597099304199219, $bt->end('0.31031500 1439136999'));
    }

}
