<?php
/**
 * IoCRegistry.php.
 */

namespace Tinker\Di;

/**
 * A registry style singleton for inversion of control.
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
class IoCRegistry implements IoCRegistryInterface
{

    /**
     * An array of registered containers
     * @var array
     */
    protected static $registry = array();

    /**
     * Adds a container to the registry.
     * 
     * @param  string $name
     * @param  object $container
     * @return void
     */
    public static function register($name, $container)
    {
        self::$registry[$name] = $container;
    }

    /**
     * Removes a container from the registry.
     * 
     * @param type $name
     * @retern void
     */
    public static function unregister($name)
    {
        unset(self::$registry[$name]);
    }

    /**
     * Returns true if a given container has been registered.
     * 
     * @param  string $name
     * @return bool
     */
    public static function registered($name)
    {
        return array_key_exists($name, self::$registry);
    }

    /**
     * Returns a list of all containers in the registry.
     * 
     * @return void
     */
    public static function registry()
    {
        return self::$registry;
    }

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
    public static function resolve($name)
    {
        $obj = null;

        if (self::registered($name))
        {
            $obj = self::$registry[$name];
            return $obj();
        }

        throw new \Exception("Tinker: Container {{$name}} not found.");
    }

}
