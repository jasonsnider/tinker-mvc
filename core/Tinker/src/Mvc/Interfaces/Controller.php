<?php
/**
 * Controller.php
 */
namespace Tinker\Mvc\Interfaces;

/**
 * A base controller
 */
interface Controller
{

    /**
     * Sets dependencies on startup
     * 
     * @param object $Theme
     * @param object $View
     * @param object $Model
     * @retrun void
     */
    public function __construct(Theme $Theme, View $View);

    /**
     * Injects dependencies into an object
     *
     * @param object $Object
     * @retrun void
     */
    public function inject($Object);

    /**
     * A setter for $View
     * 
     * @param object $View
     * @retrun void
     */
    public function setView(View $View);

    /**
     * A setter for $Theme
     * 
     * @param object $Theme
     * @retrun void
     */
    public function setTheme(Theme $Theme);

    /**
     * Renders the view on shutdown
     * 
     * @return void
     * @retrun void
     */
    public function __destruct();
}
