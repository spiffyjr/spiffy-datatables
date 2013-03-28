<?php

namespace SpiffyDatatablesTest\Assets;

use SpiffyDatatables\Options\AbstractOptions;

class SimpleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $options = array(
        'foo' => null,
        'bar' => null
    );
}