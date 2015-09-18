<?php
/**
 * Unit tests and mock objects for the IoCRegistry class
 */

/**
 * Just a mock object to test container instantiation
 */
class IoCRegistryMockTestObject
{

    public function foo()
    {
        return 'bar';
    }
}

/**
 * Just a mock object to test container instantiation
 */
class IoCRegistryMockTestObjectToBeAdded
{

    public function foo()
    {
        return 'bar';
    }
}

/**
 * A unit test for the IoCRegistry class
 */
class IoCRegistryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * We will start by adding a single container to the registery
     */
    public function __construct()
    {
        //Add an initial container to the registry
        \Tinker\Di\IoCRegistry::register('IoCRegistryMockTestObject', function() {
            $IoCRegistryMockTestObject = new IoCRegistryMockTestObject;
            return $IoCRegistryMockTestObject;
        });
    }

    /**
     * Test registry retrival by confirming the expected containers exist and
     * non-registered containers do not.
     */
    public function testGetRegistry()
    {
        $this->assertArrayHasKey('IoCRegistryMockTestObject', \Tinker\Di\IoCRegistry::registry());
        $this->assertArrayNotHasKey('IoCRegistryMockTestObjectXXXXXXXXXX', \Tinker\Di\IoCRegistry::registry());
    }

    /**
     * Test the ability to instantiate a container when the requested continer
     * exists and verify that calling an unregistered container will result in an error.
     * 
     * @expectedException Exception
     */
    public function testCreateInstanceAnOfAIoCRegistry()
    {

        $IoCRegistryMockTestObject = \Tinker\Di\IoCRegistry::resolve('IoCRegistryMockTestObject');
        $this->assertSame('bar', $IoCRegistryMockTestObject->foo());

        //Unregistered containers MUST throw an exception
        $AssertWillThrowException = \Tinker\Di\IoCRegistry::resolve('ThisWillThrowAnException');
    }

    /**
     * Test adding new containers to the registry
     */
    public function testAddAContainerToTheRegistry()
    {

        $this->assertFalse(\Tinker\Di\IoCRegistry::registered('IoCRegistryMockTestObjectToBeAdded'));

        \Tinker\Di\IoCRegistry::register('IoCRegistryMockTestObjectToBeAdded', function() {
            $IoCRegistryMockTestObjectToBeAdded = new IoCRegistryMockTestObjectToBeAdded;
            return $IoCRegistryMockTestObjectToBeAdded;
        });

        $this->assertArrayHasKey('IoCRegistryMockTestObjectToBeAdded', \Tinker\Di\IoCRegistry::registry());
    }

    /**
     * Test removing containers from the registry
     */
    public function testRemoveAContainerFromTheRegistry()
    {

        $count = count(\Tinker\Di\IoCRegistry::registry());

        $this->assertArrayHasKey('IoCRegistryMockTestObject', \Tinker\Di\IoCRegistry::registry());

        \Tinker\Di\IoCRegistry::unregister('IoCRegistryMockTestObject');
        $this->assertArrayNotHasKey('IoCRegistryMockTestObject', \Tinker\Di\IoCRegistry::registry());

        //Make sure only one container is removed
        $this->assertSame(count(\Tinker\Di\IoCRegistry::registry()), ($count - 1));
    }
}
