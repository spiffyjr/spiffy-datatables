<?php

return array(
    'loader_paths' => array(
        'SpiffyDatatablesTest' => __DIR__ . '/../test'
    ),
    'modules' => array(
        'SpiffyDatatables'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            '../../../config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ),
);
