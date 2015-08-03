<?php

class RouterTest extends \PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
		$this->MockUri1 = new \Tinker\Mvc\Router('/');
		$this->MockUri2 = new \Tinker\Mvc\Router('/plugin');
		$this->MockUri3 = new \Tinker\Mvc\Router('/plugin/controller');
		$this->MockUri4 = new \Tinker\Mvc\Router('/plugin/controller/action');
		$this->MockUri5 = new \Tinker\Mvc\Router('/plugin/controller/action/param');
		$this->MockUri6 = new \Tinker\Mvc\Router('/plugin/controller/action/pass1/pass2/named1:1/pass3/named2:2');
	}

	public function testPlugins()
	{
		$this->assertSame('tinker_plugin', $this->MockUri1->getPlugin());
		$this->assertSame('plugin', $this->MockUri2->getPlugin());
		$this->assertSame('plugin', $this->MockUri3->getPlugin());
		$this->assertSame('plugin', $this->MockUri4->getPlugin());
		$this->assertSame('plugin', $this->MockUri5->getPlugin());
	}

	public function testControllers()
	{
		$this->assertSame('tinker_plugin', $this->MockUri1->getController());
		$this->assertSame('plugin', $this->MockUri2->getController());
		$this->assertSame('controller', $this->MockUri3->getController());
		$this->assertSame('controller', $this->MockUri4->getController());
		$this->assertSame('controller', $this->MockUri5->getController());
	}

	public function testActions()
	{
		$this->assertSame('index', $this->MockUri1->getAction());
		$this->assertSame('index', $this->MockUri2->getAction());
		$this->assertSame('index', $this->MockUri3->getAction());
		$this->assertSame('action', $this->MockUri4->getAction());
		$this->assertSame('action', $this->MockUri5->getAction());
	}

	public function testParams()
	{
		$this->assertSame(array('named' => array(), 'passed' => array(0 => 'param')), $this->MockUri5->getParams());
		$this->assertSame(
			array(
			'named' => array(
				'named1' => '1',
				'named2' => '2'
			),
			'passed' => array(
				0 => 'pass1',
				1 => 'pass2',
				2 => 'pass3'
			)
			), $this->MockUri6->getParams()
		);
	}

}