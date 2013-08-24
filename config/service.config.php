<?php

return array(
    'aliases' => array(
        'SpiffyDatatables\Manager' => 'SpiffyDatatables\DatatableManager',
    ),
    'factories' => array(
        'SpiffyDatatables\DatatableManager' => 'SpiffyDatatables\DatatableManagerFactory',
        'SpiffyDatatables\ModuleOptions'    => 'SpiffyDatatables\ModuleOptionsFactory',
    )
);