<?php
/**
 * Theme.php.
 */
namespace Tinker\Mvc;

/**
 * Theme.
 * Any plugin with at least one file in it's layouts directory qualifies as a
 * theme.
 *
 * Set the following from any Controller's action or constructor to set a theme
 * and layout.
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
class Theme implements Interfaces\Theme
{
    /**
     * Router.
     *
     * @var object
     */
    public $Router;

    /**
     * View.
     *
     * @var object
     */
    public $View;

    /**
     * Loader.
     *
     * @var object
     */
    public $Loader;

    /**
     * Holds the default theme.
     *
     * @var string
     */
    private $theme;

    /**
     * Holds the default layout.
     *
     * @var string
     */
    private $layout;

    /**
     * Sets dependencies.
     *
     * @param object $router
     * @param object $view
     * @param object $loader
     */
    public function __construct(Interfaces\Router $router, Interfaces\View $view, $loader)
    {
        $this->Router = $router;
        $this->View = $view;
        $this->Loader = $loader;

        $this->theme = \Tinker\Configure::read('theme');
        $this->layout = \Tinker\Configure::read('layout');
    }

    /**
     * Sets the theme.
     *
     * @use Set in a controller action
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Sets the layout.
     *
     * @use Set in a controller action
     *
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Returns the current theme.
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Returns the current theme.
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Processes all theme logic, injects the output of a view and returns the
     * result as a string.
     *
     * @param object $View Allows the $View object to be accessable from with
     * in a view file
     *
     * @return string Echoing this string will render a webpage
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * Passing $View into this function makes the $View allows template and
     * view files to access the variables set in the controller dispite not
     * being used in the method.
     */
    public function render($View)
    {
        $file = null;
        $theme = $this->getTheme();
        $layout = $this->getLayout();

        //Autoload the theme paths
        $this->Loader->addNamespace(
            $theme,
            'plugin'.DS.$theme.DS.'src'
        );

        $this->Loader->addNamespace(
            $theme,
            APP.DS.'plugin'.DS.$theme.DS.'src'
        );

        $paths = $this->Loader->getPrefixes();
        //var_dump($paths);
        for ($i = 0; $i < count($paths["{$theme}\\"]); ++$i) {
            $check = $paths["{$theme}\\"][$i].
                'View'.DS.'layouts'.DS.$layout.'.php';

            if (is_file($check)) {
                $file = $check;
            } else {
                //If the literal path does not resolve, check against the include
                //paths
                $iPaths = explode(PATH_SEPARATOR, get_include_path());
                foreach ($iPaths as $path) {
                    if (file_exists($path.DS.$check)) {
                        $file = $path.DS.$check;
                    }
                }
            }
        }

        ob_start();
        require_once $file;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
