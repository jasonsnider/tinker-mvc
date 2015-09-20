<?php
/**
 * Router
 */
namespace Tinker\Mvc;

/**
 * Router maps a request to an MVC path by parsing out the URI and setting the 
 * target plugin, controller, action and parameters
 * 
 * Given the URI /example/main/index/p1/p2/p3/p4:1
 * We would be passing 4 GET parameters (where p4 is a named key to value pair 
 * and p1 - p3 would be assigned numeric keys) into the index action of the main 
 * controller of the example plugin.
 * 
 * The name of the plugin MUST also be that plugins namespace.
 * 
 */
class Router implements Interfaces\Router
{

    use \Tinker\Utility\Inflector;

    /**
     * Holds the current plugin
     * @var string
     */
    private $plugin = 'tinker_plugin';

    /**
     * Holds the current controller
     * @var string
     */
    private $controller = 'tinker_plugin';

    /**
     * Holds the current action
     * @var string 
     */
    private $action = 'index';

    /**
     * Holds the current list of params
     * @var array
     */
    private $params = array(
        'named' => array(),
        'passed' => array()
    );

    /**
     * Sets the URI for parsing or retrives an asset file.
     *
     * @param string $requestUri Represents the URI to be parsed
     * @param object $Loader
     * @return void
     */
    public function __construct($requestUri)
    {
        $this->parseUri($requestUri);
    }

    /**
     * Parse out the URI to determine the MVC routing
     * 0 /main/main/index
     * 1 /[plugin]/[plugin]/index
     * 2 /[plugin]/[controller]/index
     * 3 /[plugin]/[controller]/[action]
     * 4 /[plugin]/[controller]/[action]/[params]
     * Any params not falling into on of the above categories will be added as 
     * named or numbered params
     */
    public function parseUri($requestUri)
    {
        //Parse each URI segment into it's own element then remove all elements 
        //with an empty value.
        $uriSegments = array_filter(explode('/', $requestUri));
        $uriLegnth = count($uriSegments);

        switch ($uriLegnth) {
            case 0:
                $this->setPlugin(\Tinker\Configure::read('plugin'));
                $this->setController(\Tinker\Configure::read('controller'));
                $this->setAction('index');
                break;

            case 1:
                $this->setPlugin($uriSegments[1]);
                $this->setController($uriSegments[1]);
                $this->setAction('index');
                break;

            case 2:
                $this->setPlugin($uriSegments[1]);
                $this->setController($uriSegments[2]);
                $this->setAction('index');
                break;

            case 3:
                $this->setPlugin($uriSegments[1]);
                $this->setController($uriSegments[2]);
                $this->setAction($uriSegments[3]);
                break;

            //Greater than 3
            default:
                $this->setPlugin($uriSegments[1]);
                $this->setController($uriSegments[2]);
                $this->setAction($uriSegments[3]);
                $this->setParams(array_slice($uriSegments, 3));
                break;
        }
    }

    /**
     * Returns a file path if a given route maps to a plugins webroot
     * directory. Retruns false if the given route does not map to a webroot
     * asset.
     * 
     * @return mixed
     */
    public function checkAsset($Loader)
    {
        //The plugin name as it appears on the servers file path
        $plugin = $this->getPlugin(true);

        //The requested action, for assets this will be the file name
        $action = $this->getAction();

        //the controller name as it appears in the url. If it is an asset it
        // will be jc, css, img, doc, etc...
        $controller = $this->getController(false);

        //All registered auto loader prefixes
        $paths = $Loader->getPrefixes();

        //Holds an asset's file path. If mulitpe paths contain an asset of the
        //same name, the last path containing the asset wins
        $asset = false;

        if (!empty($paths["{$plugin}\\"])) {
            for ($i = 0; $i < count($paths["{$plugin}\\"]); $i++) {
                $check = $paths["{$plugin}\\"][$i] . 'webroot' . DS . $controller . DS . $action;

                if (is_file($check)) {
                    $asset = $check;
                } else {
                    //If the literal path does not resolve, check against the include
                    //paths
                    $iPaths = explode(PATH_SEPARATOR, get_include_path());
                    foreach ($iPaths as $path) {
                        if (is_file($path . DS . $check)) {
                            $asset = $path . DS . $check;
                        }
                    }
                }
            }
        }



        if (is_file($asset)) {
            return $asset;
        }

        return false;
    }

    /**
     * If the requested URL is a webroot asset living in a plugin (.css, .js,
     * .jpeg, .doc, etc ) then that file is written to and echoed from the
     * buffer and all execution halts.
     *
     * @param string $asset
     * @return mixed
     */
    public function fetchAsset($asset)
    {

        //If the request is a real file from the requested plugin
        if (is_file($asset)) {

            $info = pathinfo($asset);


            //Start the buffer
            ob_start();

            if (array_key_exists('extension', $info)) {
                if ($info['extension'] === 'js') {
                    header("Content-type: text/javascript");
                } else {
                    header("Content-type: text/{$info['extension']}");
                }
            }

            //Grab the file and write it to the buffer
            require $asset;

            //Write the buffer to a variable
            $output = ob_get_contents();

            //Clean the buffer
            ob_end_clean();

            //echo the buffer and halt execution
            echo $output;
            //die();
        }

        return false;
    }

    /**
     * Sets the current plugin
     * @param string $plugin
     * @return void
     */
    public function setPlugin($plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Sets the current controller
     * @param string $controller
     * @return void
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Sets the current action
     * @param string $action
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Sends an array of $_GET like parameters to a parser for setting
     * @param array $params
     * @retun void
     */
    public function setParams($params)
    {
        for ($x = 0; $x < count($params); $x++) {
            $this->setParam($params[$x]);
        }
    }

    /**
     * Sets a single param as either a named or passed parameter (this is akin to a get param)
     * @return void
     */
    public function setParam($param)
    {

        //If the string contains a colon, assume it to be a named param
        if (strpos($param, ':')) {
            $pair = explode(':', $param);
            $this->params['named'][$pair[0]] = $pair[1];
        } else {
            //Add the string with a numeric index
            if (!in_array($param, $_GET)) {
                $this->params['passed'][] = $param;
            }
        }
    }

    /**
     * Returns the current plugin
     * @param string $studlyCaps returns the plugin as a studlyCapsd string if set to true
     * @return string
     */
    public function getPlugin($studlyCaps = false)
    {
        return $studlyCaps ? $this->studlyCaps($this->plugin) : $this->plugin;
    }

    /**
     * Returns the current controller
     * @param string $studlyCaps returns the controller as a studlyCapsd string if set to true
     * @return string
     */
    public function getController($studlyCaps = false)
    {
        return $studlyCaps ? $this->studlyCaps($this->controller) : $this->controller;
    }

    /**
     * Returns the current action
     * @param string $studlyCaps returns the action as a studlyCapsd string if set to true
     * @return string
     */
    public function getAction($studlyCaps = false)
    {
        return $studlyCaps ? $this->studlyCaps($this->action) : $this->action;
    }

    /**
     * Returns the current params
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}
