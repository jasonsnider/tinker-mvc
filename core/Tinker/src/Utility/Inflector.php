<?php
/**
 * Inflector.php
 */
namespace Tinker\Utility;

/**
 * Provides inflection
 */
trait Inflector
{

    /**
     * Converts a string to StudlyCaps
     * @param string $string
     * @return string
     */
    public function studlyCaps($string)
    {
        return str_replace('_', '', mb_convert_case($string, MB_CASE_TITLE, "UTF-8"));
    }

    /**
     * Converts a string to camelCase
     * @param string $string
     * @return string
     */
    public function camelCase($string)
    {
        return preg_replace_callback('/(?!^)_([a-z])/', function($str)
        {
            return strtoupper($str[1]);
        }, $string);
    }
}
