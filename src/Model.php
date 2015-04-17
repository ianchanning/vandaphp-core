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

class Model
{
    /**
     * @var string Model name  
     */
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the model data
     */
    public function get()
    {
        
    }
}
