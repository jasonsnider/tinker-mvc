<?php
/**
 * Controller.php
 */

namespace Tinker\Mvc;

/**
 * A base controller
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
     * @param object $Theme
     * @param object $View
     * @param object $Model
     * @retrun void
     */
    public function __construct(Interfaces\Theme $Theme, Interfaces\View $View, $Model)
    {
        $this->setView($View);
        $this->setTheme($Theme);
        $this->setModel($Model);
    }

    /**
     * A setter for Model objects
     * 
     * @param object $model
     * @retrun void
     */
    public function setModel($Model)
    {
        $rc = new \ReflectionClass($Model);
        $name = $rc->getShortName();
        $this->{$name} = $Model;
    }

    /**
     * A setter for $View
     * 
     * @param object $View
     * @retrun void
     */
    public function setView(Interfaces\View $View)
    {
        $this->View = $View;
    }

    /**
     * A setter for $Theme
     * 
     * @param object $Theme
     * @retrun void
     */
    public function setTheme(Interfaces\Theme $Theme)
    {
        $this->Theme = $Theme;
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
