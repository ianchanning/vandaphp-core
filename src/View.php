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
 * Central class to generate the view output
 */
class View
{
    /**
     * @var string The layout title 
     */
    public $title;
    
    /**
     * Create the output by combining content with the layout
     * 
     * @param string $contentForLayout content to be echoed in the $layout
     * @param string $layout Layout template
     */
    public function render($contentForLayout, $layout)
    {
        require_once 'Views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $layout . '.php';
    }
}
