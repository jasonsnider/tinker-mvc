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
     * Converts a string to studly caps
     * @param string $string
     * @return string
     */
    public function studlyCaps($string)
    {
        return str_replace('_', '', mb_convert_case($string, MB_CASE_TITLE, "UTF-8"));
    }
}
