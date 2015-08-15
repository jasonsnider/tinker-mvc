<?php
/**
 * TinkerPlugin Controller
 */
namespace Application\Controller;

/**
 * TinkerPlugin Controller
 * 
 * Just a mock up of a controller
 */
class ApplicationController extends \Tinker\Mvc\Controller
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
        $this->View->vars['welcome'] = $this->Application->welcome();
    }

}
