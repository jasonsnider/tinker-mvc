<?php
/**
 * IoCRegistry.php
 * 
 * A registry e stysingleton for inversion of control
 */
namespace Tinker\Di;

/**
 * An IoC Registry
 * 
 * A registry e stysingleton for inversion of control
 */
interface IoCRegistryInterface
{

    /**
     * Adds a container to the registry
     * @param  string $name
     * @param  object $container
     * @return void
     */
	public static function register($name, $container);

	/**
	 * Removes a container from the registry
	 * @param type $name
	 * @retern void
	 */
	public static function unregister($name);
	
    /**
     * Returns true if a give container has been registered
     * @param  string $name
     * @return bool
     */
    public static function registered($name);
	
	/**
	 * Returns the registry array
	 * @return void
	 */
	public static function registry();
 
	/**
	 * 
     * Create an instance of a registered container. Throws an Exception if the container is not registered
     * @param  string $name
     * @return mixed
	 * @throws \Exception
	 */
    public static function resolve($name);

}