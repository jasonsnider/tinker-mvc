<?php
/**
 * View
 */
namespace Tinker\Mvc;

/**
 * View
 *
 * All properties of view SHOULD have public exposure. This will allow us to
 * work with a given instance from inside of theme and view files.
 */
class View implements Interfaces\View
{

    /**
     * Holds variables for the view.
     *
     * @var array
     */
    public $vars;

    /**
     * Holds the BuildTime object
     * @var object
     */
    public $BuildTime;

    /**
     * Holds the Router object
     * @var object
     */
    public $Router;

    /**
     * Holds the Loader object
     * @var object
     */
    public $Loader;

    public function __construct(Interfaces\Router $router, $buildTime, $loader)
    {
        $this->BuildTime = $buildTime;
        $this->Router = $router;
        $this->Loader = $loader;
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

        for ($i = 0; $i < count($paths["{$plugin}\\"]); $i++) {
            $check = $paths["{$plugin}\\"][$i] . 'View' . DS . $controller . DS . $action . '.php';

            if (is_file($check)) {
                $file = $check;
            } else {
                //If the literal path does not resolve, check against the include
                //paths
                $iPaths = explode(PATH_SEPARATOR, get_include_path());
                foreach ($iPaths as $path) {
                    if (file_exists($path . DS . $check)) {
                        $file = $path . DS . $check;
                    }
                }
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
