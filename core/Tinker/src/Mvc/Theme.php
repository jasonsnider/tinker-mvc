<?php

/**
 */

namespace Tinker\Mvc;

/**
 * Theme
 * Any plugin with at least one file in it's layouts directory qualifies as a theme.
 * 
 * Set the following from any Controller's action or constructor to set a theme and layout.
 * <?php 
 * class FooController extends Controller{
 *       //Sets the theme for all actions in a single controller
 * 		 public function __construct(){
 * 			parent::__construct();
 * 			$this->Theme->setTheme('Foo');
 * 			$this->Theme->setLayout('bar');
 * 		}
 * 
 *       //Sets the theme for a single action
 * 		 public function index(){
 * 			parent::__construct();
 * 			$this->Theme->setTheme('NewFoo');
 * 			$this->Theme->setLayout('new_bar');
 * 		}	
 */
class Theme implements ThemeInterface
{
    
    /**
     * Router
     * @var object
     */
    public $Router;
    
    /**
     * View
     * @var object
     */
    public $View;
    
    /** 
     * Loader
     * @var object
     */
    public $Loader;

    /**
     * Sets dependencies
     * 
     * @param object $Router
     * @param object $View
     * @param object $Loader
     * @return void
     */
    public function __construct($Router, $View, $Loader)
    {
        $this->Router = $Router;
        $this->View = $View;
        $this->Loader = $Loader;
    }

    /**
     * Holds the default theme
     * @var string
     */
    private $theme = 'TinkerPlugin';

    /**
     * Holds the default layout
     * @var string
     */
    private $layout = 'default';

    /**
     * Sets the theme 
     * @use Set in a controller action
     * @param string $theme
     */
    public function setTheme($theme)
    {

        $this->theme = $theme;
    }

    /**
     * Sets the layout
     * @use Set in a controller action
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Returns the current theme
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Returns the current theme
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Processes all theme logic, injects the output of a view and returns the result as a string.
     * @param Object $View Allows the $View object to be accessable from with in a view file
     * @return string Echoing this string will render a webpage
     */
    public function render($View)
    {

        $file = null;
        $theme = $this->getTheme();
        $layout = $this->getLayout();

        $paths = $this->Loader->getPrefixes();

        for ($i = 0; $i < count($paths["{$theme}\\"]); $i++)
        {
            $check = $paths["{$theme}\\"][$i] .
                    'View' . DS . 'layouts' . DS . $layout . '.php';

            if (is_file($check))
            {
                $file = $check;
            }
        }

        ob_start();
        require_once $file;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

}
