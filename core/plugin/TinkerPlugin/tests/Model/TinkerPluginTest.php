<?php

/**
 * All an extended controller test really needs to do is call each action to verifiy
 * nothing is causing an error. THe functionality is tested in ControllerTest.
 */
class TinkerPluginTest extends \PHPUnit_Framework_TestCase
{

    public function testWelcome()
    {
        $model = new \TinkerPlugin\Model\TinkerPlugin;
        $this->assertSame('Welcome to TinkerMVC', $model->welcome());
    }
}
