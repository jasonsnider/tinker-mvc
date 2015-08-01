<?php
/**
 * IoCRegistry.php.
 */
namespace Tinker\Di;

/**
 * Defines a registry style singleton for inversion of control.
 * 
 * The IoCRegistry allows for the management dependency injection containers,
 * using a basic CRUD like pattern to manage an array of key to value pairs.
 * 
 * For this interface 
 * * create is defined as register.
 * * read is defined as registry (all containers), registered (really more of a
 * check) and/or resolve (perhaps invoke is a better. 
 * term, iCRUD?).
 * * update is also defined as register as passing an exisiting container 
 * name will overwrite it.
 * * delete is defined as unregister
 */
interface IoCRegistryInterface
{

    /**
     * Adds a container to the registry.
	 * 
     * @param  string $name
     * @param  object $container
     * @return void
     */
	public static function register($name, $container);

	/**
	 * Removes a container from the registry.
	 * 
	 * @param type $name
	 * @retern void
	 */
	public static function unregister($name);
	
    /**
     * Returns true if a given container has been registered.
	 * 
     * @param  string $name
     * @return bool
     */
    public static function registered($name);
	
	/**
	 * Returns a list of all containers in the registry.
	 * 
	 * @return void
	 */
	public static function registry();
 
	/**
     * Instantiates a registered container. 
	 * 
	 * Instantiates a registered container. Throws an Exception if the 
	 * container is not registered.
	 * 
     * @param  string $name
     * @return mixed
	 * @throws \Exception
	 */
    public static function resolve($name);
}