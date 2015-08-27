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
        $this->MockUri7 = new \Tinker\Mvc\Router('/tinker_plugin/css/empty');
        $this->MockUri8 = new \Tinker\Mvc\Router('/tinker_plugin/css/empty.css');
    }


    public function testTheDefaultPluginIsRetrunedWhenNoPluginIsRequested(){
        $this->assertSame('tinker_plugin', $this->MockUri1->getPlugin());
    }

    public function testTheRequestedPluginIsRetrunedWhenRequestAPluginIsReqested()
    {
        $this->assertSame('plugin', $this->MockUri2->getPlugin());
        $this->assertSame('plugin', $this->MockUri3->getPlugin());
        $this->assertSame('plugin', $this->MockUri4->getPlugin());
        $this->assertSame('plugin', $this->MockUri5->getPlugin());
    }

    public function testTheDefaultControllerIsRetrunedWhenNoControllerIsRequested(){
        $this->assertSame('tinker_plugin', $this->MockUri1->getController());
        $this->assertSame('plugin', $this->MockUri2->getController());
    }

    public function testTheRequestedControllerIsRetrunedWhenAControllerIsRequested()
    {
        $this->assertSame('controller', $this->MockUri3->getController());
        $this->assertSame('controller', $this->MockUri4->getController());
        $this->assertSame('controller', $this->MockUri5->getController());
    }

    public function testTheDefaultActionIsRetrunedWhenNoActionIsRequested()
    {
        $this->assertSame('index', $this->MockUri1->getAction());
        $this->assertSame('index', $this->MockUri2->getAction());
        $this->assertSame('index', $this->MockUri3->getAction());
    }

    public function testTheRequestedActionIsRetrunedWhenAnActionIsRequested()
    {
        $this->assertSame('action', $this->MockUri4->getAction());
        $this->assertSame('action', $this->MockUri5->getAction());
    }

    public function testNamedParamsAreGivenNamedKeysAndPassedParamsAreGivenNumericKeys()
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

    public function testCheckAssetReturnsAFilePathWhenTheRequestedUriIsAPluginAsset(){
        //not empty === false
        $test = empty($this->MockUri7->checkAsset(\Tinker\TestGlobals::getGlobal('Loader')));
        $this->assertFalse($test);
    }

    public function testCheckAssetReturnsFalseWhenTheRequestedUriIsNotAPluginAsset(){
        //is empty === true
        $testMissingFile = empty($this->MockUri8->checkAsset(\Tinker\TestGlobals::getGlobal('Loader')));
        $this->assertTrue($testMissingFile);
    }

    public function testFetchAssetReturnsTheBufferContentsWhenTheRequestedUriIsAPluginAsset(){

        ob_start();
        $this->MockUri7->fetchAsset($this->MockUri7->checkAsset(\Tinker\TestGlobals::getGlobal('Loader')));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertSame('this file is empty', $output);
        
    }

    public function testFetchAssetReturnsFalseWhenTheRequestedUriIsNotAPluginAsset(){
        //is empty === true
       $testMissingFile = empty($this->MockUri8->fetchAsset($this->MockUri7->checkAsset(\Tinker\TestGlobals::getGlobal('Loader'))));
       $this->assertTrue($testMissingFile);
    }

}
