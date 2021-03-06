<?php
/**
 * A class for managing runtime variables
 */
namespace Tinker;

/**
 * A class for managing runtime variables
 */
class Configure
{

    private static $vars = array();

    /**
     * Write a variable to the configuration array
     * @param string $var
     * @param mixed $val
     * @return void
     * @throws Exception
     */
    public static function write($var, $val)
    {
        if (empty(self::$vars[$var])) {
            return self::$vars[$var] = $val;
        }

        throw new \Exception(
            "Tinker: Cannot redeclare configuration variable {{$var}}"
        );

    }

    /**
     * Reads a value from the configuration array.
     * Passing a null key returns the entire configuration
     * @param string $var
     * @return mixed
     */
    public static function read($var = null)
    {
        if (empty($var)) {
            return self::$vars;
        }

        if (array_key_exists($var, self::$vars)) {
            return self::$vars[$var];
        }

        return null;
    }
}
