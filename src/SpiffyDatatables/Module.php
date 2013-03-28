<?php

namespace SpiffyDatatables;

class Module
{
    public function getConfig()
    {
        return array(
            'view_helpers' => array(
                'invokables' => array(
                    'datatable' => 'SpiffyDatatables\View\Helper\Datatable'
                )
            )
        );
    }
}