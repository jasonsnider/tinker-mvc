<?php
/**
 * TinkerPlugin Controller
 */

namespace TinkerPlugin\Controller;

/**
 * TinkerPlugin Controller
 * 
 * Just a mock up of a controller
 */
class TinkerPluginController extends \Tinker\Mvc\Controller
{

    /**
     * Provides a default landing page for TinkerMVC
     * 
     * Sets View::vars an example of how to inject variables into the view
     * 
     * @return void
     */
    public function index()
    {
        $this->View->vars['welcome'] = $this->TinkerPlugin->welcome();
    }

}
