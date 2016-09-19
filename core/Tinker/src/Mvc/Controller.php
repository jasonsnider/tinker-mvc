<?php
/**
 * Controller
 */
namespace Tinker\Mvc;

/**
 * Controller
 */
abstract class Controller implements Interfaces\Controller
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
     * @param object $theme
     * @param object $view
     *
     * @retrun void
     */
    public function __construct(Interfaces\Theme $theme, Interfaces\View $view)
    {
        $this->setView($view);
        $this->setTheme($theme);
    }

    /**
     * Injects dependencies into an object
     *
     * @param object $object
     *
     * @retrun void
     */
    public function inject($object)
    {
        $rc = new \ReflectionClass($object);
        $name = $rc->getShortName();
        $this->{$name} = $object;
    }

    /**
     * A setter for $View
     *
     * @param object $view
     *
     * @retrun void
     */
    public function setView(Interfaces\View $view)
    {
        $this->View = $view;
    }

    /**
     * A setter for $Theme
     *
     * @param object $Theme
     * @retrun void
     */
    public function setTheme(Interfaces\Theme $theme)
    {
        $this->Theme = $theme;
    }

    /**
     * Renders the view on shutdown
     *
     * @return void
     * @retrun void
     */
    public function __destruct()
    {
        echo $this->Theme->render($this->View);
    }
}
