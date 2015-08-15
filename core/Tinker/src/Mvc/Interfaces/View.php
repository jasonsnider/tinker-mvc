<?php
/**
 */

namespace Tinker\Mvc\Interfaces;

/**
 * View Class
 */
interface View
{

    /**
     * Sets the path for from which we are to render a view
     * @return type
     */
    public function setViewPath();

    /**
     * Processes all view logic and returns it's output as a string
     * @return string
     */
    public function getOutput();

}