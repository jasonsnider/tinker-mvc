<?php
/**
 * Controller
 */
namespace Tinker\Mvc\Interfaces;

/**
 * Controller
 */
interface Controller
{

    /**
     * Sets dependencies on startup
     *
     * @param object $theme
     * @param object $view
     * @retrun void
     */
    public function __construct(Theme $theme, View $view);

    /**
     * Injects dependencies into an object
     *
     * @param object $object
     * @retrun void
     */
    public function inject($object);

    /**
     * A setter for $View
     *
     * @param object $view
     * @retrun void
     */
    public function setView(View $view);

    /**
     * A setter for $Theme
     *
     * @param object $theme
     * @retrun void
     */
    public function setTheme(Theme $theme);

    /**
     * Renders the view on shutdown
     *
     * @return void
     * @retrun void
     */
    public function __destruct();
}
