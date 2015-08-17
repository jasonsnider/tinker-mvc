<?php
/**
 */

namespace Tinker\Mvc\Interfaces;

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
interface Theme
{

    /**
     * Sets dependencies
     * 
     * @param object $Router
     * @param object $View
     * @param object $Loader
     * @return void
     */
    public function __construct(Router $Router, View $View, $Loader);

    /**
     * Sets the layout
     * @use Set in a controller action
     * @param string $layout
     */
    public function setLayout($layout);

    /**
     * Returns the current theme
     * @return string
     */
    public function getTheme();

    /**
     * Returns the current theme
     * @return string
     */
    public function getLayout();

    /**
     * Processes all theme logic, injects the output of a view and returns the result as a string.
     * @param Object $View Allows the $View object to be accessable from with in a view file
     * @return string Echoing this string will render a webpage
     */
    public function render($View);
}
