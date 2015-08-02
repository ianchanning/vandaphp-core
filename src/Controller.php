<?php

/**
 * Vanda PHP (https://github.com/ianchanning/vandaphp-core/)
 * Copyright 2011-2015, Ian Channing
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011-2015, Ian Channing (http://ianchanning.com)
 * @link          https://github.com/ianchanning/vandaphp-core/ Vanda PHP Core
 * @package       Vanda
 * @since         VandaPHP Core v 0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace Vanda;

/**
 * N.B. This causes a fatal View class not found error if just
 * `use View`
 * but as I understand it the namespace above should mean that use should be relative
 * however I think that use doesn't use the namespace
 * class Controller extends X would use the namespace
 */
use Vanda\View;
use Vanda\Router;

class Controller
{
    public $modelName = '';
    public $viewVars = array();
    public $layout = '';

    /**
     * An array containing the class names of the models this controller uses.
     *
     * @var array Array of model objects.
     * @access public
     */
    public $modelNames = array();

    /**
     * The controller view class
     * @var object
     * @access public
     */
    public $view = null;

    public function __construct($modelName = null)
    {
        $this->modelName = $modelName;
        $this->loadModel($modelName);
        $this->layout = 'default';
        $this->view = new View();
    }

    /**
     * add variables to the array that is accessed by the view
     *
     * @param $vars array var_name => var
     * @access public
     */
    public function set($vars)
    {
        $this->viewVars = array_merge($this->viewVars, $vars);
    }

    /**
     * Loads and instantiates models required by this controller.
     *
     * @param string $modelName Name of model class to load
     * @return mixed true when single model found and instance created error returned if models not found.
     * @access public
     */
    public function loadModel($modelName = null)
    {
        $this->modelNames[] = $modelName;
        $namespaceModelName = '\\Models\\' . $modelName;
        $this->{$modelName} = new $namespaceModelName($modelName);
    }

    /**
     * extract the view variables and apply them to the view
     *
     * @access public
     */
    public function renderView($view, $action)
    {
        extract($this->viewVars);

        $file = 'Views' . DIRECTORY_SEPARATOR . $view . DIRECTORY_SEPARATOR . $action . '.php';
        // @todo Need a 'APP_PATH' constant for checking if the view exists to remove the PHP warning
        // if (file_exists($file)) {
            ob_start();
            include_once $file;
            $contentForLayout = ob_get_clean();
            if (empty($this->view->title)) {
                $this->view->title = ucfirst($view) . ' : ' . ucfirst($action);
            }
            $this->view->render($contentForLayout, $this->layout);
        // }
    }

    /**
     * Redirect to a new page, wrapper onto the PHP header function
     *
     * @param string $view View to redirect to
     * @param string $action Action to redirect to
     * @return none Uses HTTP header 301 redirect
     *
     * @access public
     */
    public function redirect($view, $action = null)
    {
        $url = Router::url($view, $action);
        exit(header("Location: $url"));
    }

}
