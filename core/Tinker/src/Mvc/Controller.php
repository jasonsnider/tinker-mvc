<?php
/**
 * Controller
 */

namespace Tinker\Mvc;

/**
 * A base controller
 */
abstract class Controller
{

    public function __construct($BuildTime)
    {
        $this->BuildTime = $BuildTime;
    }
    
    /**
     * Renders the view prior to exit
     */
    public function __destruct()
    {
        //Since a controller action should only concern itself with it's own business login,
        //it seems using the descructor for "auto-rendering" would be ideal.
        var_dump('DESTRCUTOR');
        echo $this->BuildTime->end();
    }

}
