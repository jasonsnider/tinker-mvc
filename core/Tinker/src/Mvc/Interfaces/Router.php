<?php
/**
 * Router
 */
namespace Tinker\Mvc\Interfaces;

/**
 * Router maps a request to an MVC path by parsing out the URI and setting the
 * target plugin, controller, action and parameters
 */
interface Router
{

    /**
     * Parse out the URI to determine the MVC routing
     * 0 /main/main/index
     * 1 /[plugin]/[plugin]/index
     * 2 /[plugin]/[controller]/index
     * 3 /[plugin]/[controller]/[action]
     * 4 /[plugin]/[controller]/[action]/[params]
     * Any params not falling into on of the above categories will be added as named or numbered params
     */
    public function parseUri($requestUri);

    /**
     * Sets the current plugin
     * @param string $plugin
     * @return void
     */
    public function setPlugin($plugin);

    /**
     * Sets the current controller
     * @param string $controller
     * @return void
     */
    public function setController($controller);

    /**
     * Sets the current action
     * @param string $action
     * @return void
     */
    public function setAction($action);

    /**
     * Sends an array of $_GET like parameters to a parser for setting
     * @param array $params
     * @retun void
     */
    public function setParams($params);

    /**
     * Sets a single param as either a named or passed parameter (this is akin to a get param)
     * @return void
     */
    public function setParam($param);

    /**
     * Returns the current plugin
     * @param string $studlyCaps returns the plugin as a studlyCapsd string if set to true
     * @return string
     */
    public function getPlugin($studlyCaps = false);

    /**
     * Returns the current controller
     * @param string $studlyCaps returns the controller as a studlyCapsd string if set to true
     * @return string
     */
    public function getController($studlyCaps = false);

    /**
     * Returns the current action
     * @return string
     */
    public function getAction();

    /**
     * Returns the current params
     * @return array
     */
    public function getParams();
}
