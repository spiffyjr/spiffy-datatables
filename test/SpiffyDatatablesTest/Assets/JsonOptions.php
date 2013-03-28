<?php

namespace SpiffyDatatablesTest\Assets;

use SpiffyDatatables\Options\AbstractOptions;

class JsonOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $jsonExpressions = array('function');

    /**
     * @var array
     */
    protected $options = array(
        'function' => 'function() { console.log("testing"); }'
    );
}