<?php

/**
 * TinkerMVC (https://github.com/jasonsnider/tinker-mvc)
 * 
 * @copyright Copyright (c) 2014 Jason D Snider (https://jasonsnider.com)
 * @link      https://github.com/jasonsnider/tinker-mvc
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Tinker\Mvc;

/**
 * View Class
 */
class View implements ViewInterface
{

    public function __construct($Router, $BuildTime, $Loader)
    {
        $this->BuildTime = $BuildTime;
        $this->Router = $Router;
        $this->Loader = $Loader;
    }

    /**
     * Sets the path for from which we are to render a view
     * @return type
     */
    public function setViewPath()
    {
        $plugin = $this->Router->getPlugin(true);
        $controller = $this->Router->getController();
        $action = $this->Router->getAction();
        $paths = $this->Loader->getPrefixes();

        for ($i = 0; $i < count($paths["{$plugin}\\"]); $i++)
        {
            $check = $paths["{$plugin}\\"][$i] .
                    'View' . DS .
                    $controller . DS .
                    $action . '.php';

            if (is_file($check))
            {
                $file = $check;
            }
        }


        return $file;
    }

    /**
     * Processes all view logic and returns it's output as a string
     * @return string
     */
    public function getOutput()
    {
        ob_start();
        require_once $this->setViewPath();
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

}
