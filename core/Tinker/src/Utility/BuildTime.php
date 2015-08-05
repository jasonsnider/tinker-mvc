<?php
/**
 * Approximates the time it takes the webserver to build a page.
 */

namespace Tinker\Utility;

/**
 * Approximates the time it takes the webserver to build a page.
 * 
 * Returns the ellapsed time between when it's constructed and when the end
 * method is called.
 */
class BuildTime
{

    /**
     * Holds the time at which the object was initialized
     * @var float 
     */
    private $start;

    /**
     * Sets the start time 
     * @return void
     */
    public function __construct()
    {
        $time = explode(' ', microtime());
        $this->start = $time[1] + $time[0];
    }

    /**
     * Returns the elapsed time between the initialization of the object and the calling of this method
     * @return float
     */
    public function end()
    {
        $time = explode(' ', microtime());
        $finish = $time[1] + $time[0];
        return round(($finish - $this->start), 5);
    }

}
