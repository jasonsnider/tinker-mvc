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
        
        ob_start();
        $output = 'build time: ' . $this->BuildTime->end();
        ob_end_clean();
        
        echo "<html><head><title>TinkerMVC Test</title></head><body>$output</body></html>";
    }

}
