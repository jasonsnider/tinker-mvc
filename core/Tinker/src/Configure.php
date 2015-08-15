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
    protected static $vars = array();
    
    /**
     * Write a variable to the configuration array
     * @param string $var
     * @param mixed $val
     * @return void
     */
    public static function write($var, $val)
    {
        self::$vars[$var] = $val;
    }
    
    /**
     * Reads a value from the configuration array. 
     * Passing a null key returns the entire configuration
     * @param string $var
     * @return mixed
     */
    public static function read($var = null)
    {
        if(empty($var)){
            return self::$vars;
        }
        return self::$vars[$var];
    }
}
