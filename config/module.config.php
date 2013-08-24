<?php

return array(
    'spiffy_config' => array(
        'handlers' => array(
            'SpiffyDatatables\Config\RuntimeHandler'
        )
    ),

    'view_helpers' => array(
        'factories' => array(
            'datatable' => 'SpiffyDatatables\View\Helper\DatatableFactory'
        )
    )
);