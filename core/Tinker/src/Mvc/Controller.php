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

    /**
     * Theme
     * 
     * @var object
     */
    protected $Theme;

    /**
     * View
     * 
     * @var object
     */
    protected $View;

    /**
     * Sets dependencies on startup
     * 
     * @param object $BuildTime
     * @param object $Theme
     * @param object $View
     */
    public function __construct($Theme, $View)
    {
        $this->setView($View);
        $this->setTheme($Theme);
    }

    /**
     * A setter for $View
     * 
     * @param object $View
     */
    public function setView($View)
    {
        $this->View = $View;
    }

    /**
     * A setter for $Theme
     * 
     * @param object $Theme
     */
    public function setTheme($Theme)
    {
        $this->Theme = $Theme;
    }

    /**
     * Renders the view on shutdown
     * 
     * @return void
     */
    public function __destruct()
    {
        echo $this->Theme->render($this->View);
    }

}
