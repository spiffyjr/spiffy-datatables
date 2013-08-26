<?php

namespace SpiffyDatatables\Annotation\Datatable;

use SpiffyConfig\Annotation\Service;

/**
 * @Annotation
 */
class Factory extends Service\Factory
{
    /**
     * @var string
     */
    public $key = 'spiffy_datatables|manager';
}
