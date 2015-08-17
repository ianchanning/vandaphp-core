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
 * @since         VandaPHP Core v 0.2.1
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

namespace Vanda;

class Router
{
    /**
     * Convert a view url to a Model name
     *
     * @param string $view The lower case URL view name, e.g. licence_types
     * @return string The converted name e.g. licence_types => licence types => Licence Types => LicenceTypes
     * @access public
     */
    public function viewToModel($view)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $view)));
    }

    /**
     * Convert a Model name to a view url
     *
     * @link http://www.php.net/manual/en/function.ucwords.php#92092
     * Used in controller->load_model
     *
     * @param string $model The proper case Model name, e.g. LicenceTypes
     * @return string The converted name e.g. LicenceTypes => licence_types
     * @access public
     */
    public function modelToView($model)
    {
        // e.g. from LicenceTypes replace 'eT' with 'e_T'
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $model));
    }

    /**
     * Get URL inputs and render the view
     *
     * @access public
     */
    public function dispatch()
    {
        $v              = filter_input(INPUT_GET, 'v', FILTER_UNSAFE_RAW);
        $a              = filter_input(INPUT_GET, 'a', FILTER_UNSAFE_RAW);
        $view           = (!is_null($v)) ? strtolower($v) : 'pages';
        $action         = (!is_null($a)) ? strtolower($a) : 'index';
        $model          = $this->viewToModel($view);
        $controller     = '\\Controllers\\' . $model . 'Controller';

        $controllerObj  = new $controller($model, $action);
        $controllerObj->{$action}();
        $controllerObj->renderView($view, $action);
    }

    /**
     * Get a formatted URL to a view/action
     *
     * @param string $view View
     * @param string $action Action
     * @return string $url Absolute URL http://example.com/?v=pages&a=index
     * @access public
     */
    public static function url($view, $action = null)
    {
        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $protocol = 'http';
        } else {
            $protocol = 'https';
        }
        /**
         * Handle when dirname('/index.php') ==> '\' on Windows
         * @var string
         * @todo We basically shouldn't be using dirname for a URL
         */
        $path = dirname($_SERVER['PHP_SELF']);
        if ($path === DIRECTORY_SEPARATOR) {
            $path = '/';
        }
        /**
         * @var the root URL of the website
         * @link http://stackoverflow.com/a/3429657/327074 Get base directory of current script
         */
        $baseUrl = $protocol . '://' . $_SERVER['SERVER_NAME'] . $path;

        $url = $baseUrl . "?v=$view";
        if (!is_null($action)) {
            $url .= "&a=$action";
        }
        return $url;
    }

}
