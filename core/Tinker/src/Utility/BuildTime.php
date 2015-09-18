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
     * Holds the time at which the object is initialized
     * 
     * @var float 
     */
    private $start;

    /**
     * Holds the time at which the end method is called
     * 
     * @var float 
     */
    private $finish;

    /**
     * Sets the start time
     * 
     * @return void
     */
    public function __construct($microtime)
    {
        $this->setStart($microtime);
    }

    /**
     * A setter for $start
     * 
     * @param string microtime
     * @return void
     */
    public function setStart($microtime)
    {
        $time = explode(' ', $microtime);
        $this->start = $time[1] + $time[0];
    }

    /**
     * A getter for start time
     *  
     * @return float
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * A setter for $finish
     * 
     * @param string $microtime
     * @retrun void
     */
    public function setFinish($microtime)
    {
        $time = explode(' ', $microtime);
        $this->finish = $time[1] + $time[0];
    }

    /**
     * A getter for finish
     * 
     * @return float
     */
    public function getFinish()
    {
        return $this->finish;
    }

    /**
     * Returns the elapsed time between the initialization of the object and the calling of this method
     * 
     * @return float
     */
    public function end($microtime)
    {
        $this->setFinish($microtime);
        return ($this->getFinish() - $this->getStart());
    }
}
