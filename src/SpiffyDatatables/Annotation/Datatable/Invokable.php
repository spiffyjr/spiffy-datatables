<?php

namespace SpiffyDatatables\Annotation\Datatable;

use SpiffyConfig\Annotation\Service;

/**
 * @Annotation
 */
class Invokable extends Service\Invokable
{
    /**
     * @var string
     */
    public $key = 'spiffy_datatables|manager';
}
